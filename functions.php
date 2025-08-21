<?php
// Theme setup
add_action('after_setup_theme', function () {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('html5', ['search-form','comment-form','comment-list','gallery','caption','style','script']);
  add_theme_support('custom-logo', [
    'height'      => 200,
    'width'       => 200,
    'flex-width'  => true,
    'flex-height' => true,
  ]);

  register_nav_menus([
    'primary' => __('Primary Menu', 'asli-indonesia'),
    'footer'  => __('Footer Menu', 'asli-indonesia'),
  ]);

  add_image_size('news-thumb', 800, 450, true);
});

// Enqueue CSS & JS (YOUR FILES ARE IN /assets)
add_action('wp_enqueue_scripts', function () {
  // cache-bust based on file changes (safer than theme version)
  $reset_path  = get_stylesheet_directory() . '/assets/reset.css';
  $style_path  = get_stylesheet_directory() . '/assets/style.css';
  $script_path = get_stylesheet_directory() . '/assets/script.js';

  wp_enqueue_style(
    'asli-reset',
    get_template_directory_uri() . '/assets/reset.css',
    [],
    file_exists($reset_path) ? filemtime($reset_path) : null
  );

  wp_enqueue_style(
    'asli-styles',
    get_template_directory_uri() . '/assets/style.css',
    ['asli-reset'],
    file_exists($style_path) ? filemtime($style_path) : null
  );

  // If your JS needs jQuery, uncomment:
  // wp_enqueue_script('jquery');

  wp_enqueue_script(
    'asli-script',
    get_template_directory_uri() . '/assets/script.js',
    [],
    file_exists($script_path) ? filemtime($script_path) : null,
    true
  );

  wp_localize_script('asli-script', 'ASLI', [
    'homeUrl'  => home_url('/'),
    'themeUrl' => get_template_directory_uri(),
  ]);
});
// unset wp default style ?
add_action('wp_enqueue_scripts', function () {
  wp_dequeue_style('wp-block-library');
  wp_dequeue_style('wp-block-library-theme');
  wp_dequeue_style('global-styles');
}, 100);


// Add a global Theme Options page (if ACF is active)
add_action('init', function () {
  if ( function_exists('acf_add_options_page') ) {
    acf_add_options_page([
      'page_title' => 'Theme Options',
      'menu_title' => 'Theme Options',
      'menu_slug'  => 'theme-options',
      'capability' => 'edit_theme_options',
      'redirect'   => false,
      'position'   => 61,
      'icon_url'   => 'dashicons-admin-generic',
    ]);
  }
});

//cpt menu dessert, plats, etc

/**
 * ===== 1) functions.php — Add CPT, taxonomy, meta fields, admin columns =====
 * Paste this whole block into your theme's functions.php (or a small plugin).
 */

// --- Register Custom Post Type: Resto Menu ---
add_action('init', function () {
  $labels = [
    'name'               => __('Resto Menus', 'maisonpixel'),
    'singular_name'      => __('Resto Menu', 'maisonpixel'),
    'add_new'            => __('Add New', 'maisonpixel'),
    'add_new_item'       => __('Add New Menu Item', 'maisonpixel'),
    'edit_item'          => __('Edit Menu Item', 'maisonpixel'),
    'new_item'           => __('New Menu Item', 'maisonpixel'),
    'view_item'          => __('View Menu Item', 'maisonpixel'),
    'search_items'       => __('Search Menu Items', 'maisonpixel'),
    'not_found'          => __('No menu items found', 'maisonpixel'),
    'not_found_in_trash' => __('No menu items found in Trash', 'maisonpixel'),
    'all_items'          => __('All Menu Items', 'maisonpixel'),
  ];

  register_post_type('resto_menu', [
    'labels' => $labels,
    'public' => true,
    'show_in_menu' => true,
    'show_in_rest' => true, // Gutenberg support
    'menu_icon' => 'dashicons-carrot',
    'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
    'rewrite' => ['slug' => 'resto-menu'],
    'has_archive' => false,
  ]);
});

// --- Register Taxonomy: Menu Category (maps to your menu-gallery-title sections) ---
add_action('init', function () {
  $labels = [
    'name'          => __('Menu Categories', 'maisonpixel'),
    'singular_name' => __('Menu Category', 'maisonpixel'),
    'add_new_item'  => __('Add New Menu Category', 'maisonpixel'),
    'search_items'  => __('Search Menu Categories', 'maisonpixel'),
    'all_items'     => __('All Menu Categories', 'maisonpixel'),
    'edit_item'     => __('Edit Menu Category', 'maisonpixel'),
    'update_item'   => __('Update Menu Category', 'maisonpixel'),
  ];

  register_taxonomy('menu_category', ['resto_menu'], [
    'labels' => $labels,
    'hierarchical' => true,
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    'rewrite' => ['slug' => 'menu'],
  ]);
});

// --- Ensure default terms exist after theme switch (Entrées, Plats, Desserts, Boissons) ---
add_action('after_switch_theme', function () {
  $defaults = [
    'Entrées'  => 'entrees',
    'Plats'    => 'plats',
    'Desserts' => 'desserts',
    'Boissons' => 'boissons',
  ];
  foreach ($defaults as $name => $slug) {
    if (!term_exists($name, 'menu_category')) {
      wp_insert_term($name, 'menu_category', ['slug' => $slug]);
    }
  }
});

// --- Meta Box: price + flags (vegan, spicy) ---
add_action('add_meta_boxes', function () {
  add_meta_box(
    'resto_menu_meta',
    __('Menu Item Details', 'maisonpixel'),
    function ($post) {
      $price = get_post_meta($post->ID, 'menu_price', true);
      $is_vegan = (bool) get_post_meta($post->ID, 'menu_is_vegan', true);
      $is_spicy = (bool) get_post_meta($post->ID, 'menu_is_spicy', true);
      wp_nonce_field('save_resto_menu_meta', 'resto_menu_meta_nonce');
      ?>
      <p>
        <label for="menu_price"><strong><?php _e('Price (€ or text):', 'maisonpixel'); ?></strong></label><br>
        <input type="text" id="menu_price" name="menu_price" value="<?php echo esc_attr($price); ?>" style="width: 280px;" placeholder="12.00" />
      </p>
      <p>
        <label><input type="checkbox" name="menu_is_vegan" value="1" <?php checked($is_vegan); ?>> <?php _e('Vegan', 'maisonpixel'); ?></label><br>
        <label><input type="checkbox" name="menu_is_spicy" value="1" <?php checked($is_spicy); ?>> <?php _e('Spicy', 'maisonpixel'); ?></label>
      </p>
      <p class="description">
        <?php _e('Use the main content for the description and the featured image for the item photo.', 'maisonpixel'); ?>
      </p>
      <?php
    },
    'resto_menu',
    'normal',
    'default'
  );
});

add_action('save_post_resto_menu', function ($post_id) {
  if (!isset($_POST['resto_menu_meta_nonce']) || !wp_verify_nonce($_POST['resto_menu_meta_nonce'], 'save_resto_menu_meta')) return;
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
  if (!current_user_can('edit_post', $post_id)) return;

  // Price
  if (isset($_POST['menu_price'])) {
    update_post_meta($post_id, 'menu_price', sanitize_text_field($_POST['menu_price']));
  }
  // Flags
  update_post_meta($post_id, 'menu_is_vegan', isset($_POST['menu_is_vegan']) ? '1' : '');
  update_post_meta($post_id, 'menu_is_spicy', isset($_POST['menu_is_spicy']) ? '1' : '');
});

// --- Admin list columns ---
add_filter('manage_resto_menu_posts_columns', function ($cols) {
  $cols['menu_price'] = __('Price', 'maisonpixel');
  $cols['taxonomy-menu_category'] = __('Category', 'maisonpixel');
  return $cols;
});
add_action('manage_resto_menu_posts_custom_column', function ($col, $post_id) {
  if ($col === 'menu_price') echo esc_html(get_post_meta($post_id, 'menu_price', true));
}, 10, 2);


/**
 * ===== 2) Template helpers — paste these in your Menu Page template (below get_header()) =====
 */
if (!function_exists('carte_menu_items_by_term')) {
  function carte_menu_items_by_term($term_slug, $variant = 'default') {
    $q = new WP_Query([
      'post_type' => 'resto_menu',
      'posts_per_page' => -1,
      'orderby' => ['menu_order' => 'ASC', 'title' => 'ASC'],
      'tax_query' => [[
        'taxonomy' => 'menu_category',
        'field'    => 'slug',
        'terms'    => $term_slug,
      ]],
    ]);

    $theme_uri = get_template_directory_uri();

    if ($q->have_posts()) {
      while ($q->have_posts()) { $q->the_post();
        $price    = get_post_meta(get_the_ID(), 'menu_price', true);
        $is_vegan = (bool) get_post_meta(get_the_ID(), 'menu_is_vegan', true);
        $is_spicy = (bool) get_post_meta(get_the_ID(), 'menu_is_spicy', true);
        $img      = get_the_post_thumbnail_url(get_the_ID(), 'large');
        if (!$img) { $img = $theme_uri . '/assets/src/menu (3).png'; }

        if ($variant === 'drink') {
          // --- Optional compact layout for Boissons (keeps your original drink markup) ---
          ?>
          <article class="menu-item-boisson">
            <div class="menu-item-boisson-image-wrapper">
              <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="menu-image">
            </div>
            <div class="menu-item-boisson-content">
              <h3 class="menu-item-boisson-title"><?php the_title(); ?></h3>
              <?php if ($price) : ?><p class="menu-item-boisson-price"><?php echo esc_html($price); ?></p><?php endif; ?>
            </div>
          </article>
          <?php
        } else {
          // --- Default full card layout (your <article class="resto-menu"> structure) ---
          ?>
         <article class="resto-menu">
  <div class="menu-item-image-wrapper">
    <?php if ($is_vegan): ?>
      <div class="icon-vegan">
        <img src="<?php echo esc_url($theme_uri . '/assets/src/vegan.png'); ?>" alt="Vegan Icon" class="icon-vegan-image">
      </div>
    <?php endif; ?>
    <?php if ($is_spicy): ?>
      <div class="icon-spicy">
        <img src="<?php echo esc_url($theme_uri . '/assets/src/spicy.png'); ?>" alt="Spicy Icon" class="icon-spicy-image">
      </div>
    <?php endif; ?>
    <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="menu-image">
  </div>

  <div class="menu-item-content">
    <h3 class="menu-item-title"><?php the_title(); ?></h3>
    <?php if ($price) : ?><p class="menu-item-price"><?php echo esc_html($price); ?></p><?php endif; ?>

    <?php
      $desc_raw = get_post_field('post_content', get_the_ID());
      $desc     = preg_replace('/<!--.*?-->/s', '', $desc_raw); // remove Gutenberg comments
      $desc     = wp_strip_all_tags($desc);                     // strip HTML (incl. <p>)
      $desc     = preg_replace('/\s+/', ' ', $desc);
      $desc     = trim($desc);
      if ($desc):
    ?>
      <div class="menu-item-description-wrapper">
        <p class="menu-item-description"><?php echo esc_html($desc); ?></p>
      </div>
    <?php endif; ?>
  </div>
</article>

          <?php
        }
      }
      wp_reset_postdata();
    }
  }
}

//form 7
add_filter('wpcf7_form_elements', function ($html) {
  $home = trailingslashit( home_url() );        // e.g. http://localhost/asli/
  return str_replace('{home}', esc_url($home), $html);
});

