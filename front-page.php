<?php /* front-page.php */ get_header(); ?>

<!-- Hero Section -->
<section id="hero" class="hero-section">
  <div class="hero-text">
    <?php
    $hero_logo = function_exists('get_field') ? get_field('hero_logo') : null;
    if ($hero_logo) {
      $logo_url = esc_url($hero_logo['url']);
      $logo_alt = esc_attr($hero_logo['alt'] ?: get_bloginfo('name'));
      echo "<img class=\"hero-logo\" src=\"$logo_url\" alt=\"$logo_alt\">";
    } else {
      // Fallback theme logo
      echo '<img class="hero-logo" src="'.esc_url( get_template_directory_uri().'/assets/src/logo.png' ).'" alt="'.esc_attr( get_bloginfo('name') ).'">';
    }

    $hero_title = function_exists('get_field') ? get_field('hero_title') : '';
    $hero_desc  = function_exists('get_field') ? get_field('hero_description') : '';
    ?>
    <h1 class="hero-title"><?php echo esc_html( $hero_title ?: 'Cuisine Indonésienne' ); ?></h1>
    <p class="hero-description">
      <?php echo esc_html( $hero_desc ?: "Découvrez les riches saveurs de l'Indonésie au cœur de Bordeaux." ); ?>
    </p>
  </div>

  <?php
  // Buttons (use ACF URL if set, else smart fallbacks)
  $btn1_text = function_exists('get_field') ? get_field('hero_button_1_text') : '';
  $btn1_url  = function_exists('get_field') ? get_field('hero_button_1_url') : '';
  if (!$btn1_url) {
    $p = get_page_by_path('restaurant');
    $btn1_url = $p ? get_permalink($p) : home_url('/restaurant/');
  }
  $btn2_text = function_exists('get_field') ? get_field('hero_button_2_text') : '';
  $btn2_url  = function_exists('get_field') ? get_field('hero_button_2_url') : '';
  if (!$btn2_url) {
    $p = get_page_by_path('menu');
    $btn2_url = $p ? get_permalink($p) : home_url('/menu/');
  }
  ?>
  <div class="hero-buttons">
    <button class="cta-button" type="button" onclick="location.href='<?php echo esc_url($btn1_url); ?>'">
      <?php echo esc_html( $btn1_text ?: 'Restaurant' ); ?>
    </button>

    <button class="cta-button" type="button" onclick="location.href='<?php echo esc_url($btn2_url); ?>'">
      <?php echo esc_html( $btn2_text ?: 'Voir le menu' ); ?>
    </button>
  </div>
</section>

<section id="food" class="food-section">
  <div class="food-images">
    <?php
    $fallbacks = [
      get_template_directory_uri().'/assets/src/makan (1).png',
      get_template_directory_uri().'/assets/src/makan (2).png',
      get_template_directory_uri().'/assets/src/makan (3).png',
    ];
    $food_imgs = [
      function_exists('get_field') ? get_field('food_image_1') : null,
      function_exists('get_field') ? get_field('food_image_2') : null,
      function_exists('get_field') ? get_field('food_image_3') : null,
    ];
    foreach ([0,1,2] as $i) {
      if ($food_imgs[$i]) {
        $url = esc_url($food_imgs[$i]['url']);
        $alt = esc_attr($food_imgs[$i]['alt'] ?: 'food image');
      } else {
        $url = esc_url($fallbacks[$i]);
        $alt = 'food image';
      }
      echo "<img class=\"food-image\" src=\"$url\" alt=\"$alt\">";
    }
    ?>
  </div>

  <div class="food-description">
    <h2>
      <?php
      // Allow simple inline HTML for underline, emphasis
      $headline = function_exists('get_field') ? get_field('food_headline') : '';
      $headline = $headline ?: 'Des plats <u>authentiques, faits maison</u> chaque jour avec des <u>produits frais</u> !';
      echo wp_kses( $headline, ['u'=>[], 'em'=>[], 'strong'=>[], 'br'=>[]] );
      ?>
    </h2>
    <div class="line-break"></div>
  </div>
</section>

<section id="about" class="about-section">
  <p class="about-description">
    <?php
    $about_desc = function_exists('get_field') ? get_field('about_description') : '';
    echo esc_html( $about_desc ?: "Après X années de joie à vous servir au Marché des Capucins, nous sommes ravis de vous accueillir dans notre nouveau restaurant en plein cœur de Bordeaux !" );
    ?>
  </p>

  <div class="about-social-icons">
    <?php
    $fb = function_exists('get_field') ? get_field('facebook_url') : '';
    $ig = function_exists('get_field') ? get_field('instagram_url') : '';
    $fb = $fb ?: 'https://www.facebook.com/AsliIndonesiaBordeaux';
    $ig = $ig ?: 'https://www.instagram.com/asliindonesiabordeaux/';
    ?>
    <a href="<?php echo esc_url($fb); ?>" target="_blank" rel="noopener">
      <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/logofb.svg'); ?>" alt="Facebook Logo">
    </a>
    <a href="<?php echo esc_url($ig); ?>" target="_blank" rel="noopener">
      <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/ig.svg'); ?>" alt="Instagram Logo">
    </a>
  </div>

  <div class="photo-gallery">
    <div class="gallery">
      <?php
      $gallery_fields = [
        function_exists('get_field') ? get_field('gallery_image_1') : null,
        function_exists('get_field') ? get_field('gallery_image_2') : null,
        function_exists('get_field') ? get_field('gallery_image_3') : null,
        function_exists('get_field') ? get_field('gallery_image_4') : null,
        function_exists('get_field') ? get_field('gallery_image_5') : null,
        function_exists('get_field') ? get_field('gallery_image_6') : null,
      ];
      $gallery_fallbacks = [
        get_template_directory_uri().'/assets/src/image 20.jpg',
        get_template_directory_uri().'/assets/src/restoo (1).png',
        get_template_directory_uri().'/assets/src/resto (2).jpg',
        get_template_directory_uri().'/assets/src/image 21.jpg',
        get_template_directory_uri().'/assets/src/food1.avif',
        get_template_directory_uri().'/assets/src/image 18.jpg',
      ];
      foreach ($gallery_fields as $idx => $img) {
        if ($img) {
          $url = esc_url($img['url']);
          $alt = esc_attr($img['alt'] ?: 'gallery image');
        } else {
          $url = esc_url($gallery_fallbacks[$idx]);
          $alt = 'gallery image';
        }
        echo '<div class="item"><img src="'.$url.'" alt="'.$alt.'"></div>';
      }
      ?>
      <div class="slider-controls">
        <span class="prev">&#10094;</span>
        <span class="next">&#10095;</span>
      </div>
    </div>
  </div>

  <?php
  $about_btn_text = function_exists('get_field') ? get_field('about_button_text') : '';
  $about_btn_url  = function_exists('get_field') ? get_field('about_button_url')  : '';
  if (!$about_btn_url) {
    $p = get_page_by_path('actualites');
    if (!$p) { $p = get_page_by_path('about-us'); }
    $about_btn_url = $p ? get_permalink($p) : home_url('/about-us/');
  }
  ?>
  <button class="about-button cta-button" type="button" onclick="location.href='<?php echo esc_url($about_btn_url); ?>'">
    <?php echo esc_html( $about_btn_text ?: 'Actualités' ); ?>
  </button>
</section>

<section id="contact" class="contact-section">
  <div class="line-break"></div>
  <h2 class="contact-section__title">
    <?php
    $contact_title = function_exists('get_field') ? get_field('contact_title') : '';
    echo esc_html( $contact_title ?: 'Reservation, anniversaire, entreprise, ou des commandes spécifiques ?' );
    ?>
  </h2>

  <?php
  $contact_btn_text = function_exists('get_field') ? get_field('contact_button_text') : '';
  $contact_btn_url  = function_exists('get_field') ? get_field('contact_button_url')  : '';
  if (!$contact_btn_url) {
    $p = get_page_by_path('contact');
    $contact_btn_url = $p ? get_permalink($p) : home_url('/contact/');
  }
  ?>
  <button class="contact-section__button cta-button" type="button" onclick="location.href='<?php echo esc_url($contact_btn_url); ?>'">
    <?php echo esc_html( $contact_btn_text ?: 'Contactez-nous' ); ?>
  </button>
</section>

<?php get_footer(); ?>
