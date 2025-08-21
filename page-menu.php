<?php
/* Template Name: Menu Page */
get_header(); ?>

<!-- Decorative Flower (right) -->
<div class="deco-2">
  <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/bungabatik2.png'); ?>" alt="Decoration Flower 2" class="deco-flower-2-right">
</div>


<?php
$theme_uri = get_template_directory_uri();

$menu_title    = get_field('menu_title') ?: 'Le Menu';
$menu_intro    = get_field('menu_intro');
$menu_allergen = get_field('menu_allergen');

/** build labels from up to 4 slots */
$labels = [];
for ($i = 1; $i <= 4; $i++) {
  $icon = get_field("label{$i}_icon");
  $text = trim((string) get_field("label{$i}_text"));
  if ($icon || $text) {
    $labels[] = [
      'url' => is_array($icon) ? ($icon['url'] ?? '') : $icon,
      'alt' => is_array($icon) ? ($icon['alt'] ?? $text) : ($text ?: 'Label'),
      'text'=> $text
    ];
  }
}

/** build delivery logos from up to 3 slots */
$delivery = [];
for ($i = 1; $i <= 3; $i++) {
  $logo    = get_field("delivery{$i}_logo");
  $href    = get_field("delivery{$i}_link");
  $new_tab = (bool) get_field("delivery{$i}_new_tab");
  if ($logo || $href) {
    $delivery[] = [
      'url'    => is_array($logo) ? ($logo['url'] ?? '') : $logo,
      'alt'    => is_array($logo) ? ($logo['alt'] ?? 'Logo') : 'Logo',
      'href'   => $href,
      'target' => $new_tab ? '_blank' : '_self',
      'rel'    => $new_tab ? 'noopener' : ''
    ];
  }
}
?>
<section id="menu" class="menu-section">
<div class="section-text">
  <?php
  $menu_title = get_field('menu_title') ?: 'Le Menu';
  $menu_intro = get_field('menu_intro'); // WYSIWYG or textarea
  ?>
  <h2 class="section-title"><?php echo esc_html($menu_title); ?></h2>

  <?php
  if ($menu_intro) {
    // remove Gutenberg comments + strip only block wrappers (<p>, <div>)
    $intro = preg_replace('/<!--.*?-->/s', '', $menu_intro);
    $intro = preg_replace('#</?(p|div)[^>]*>#i', '', $intro);
    $intro = trim($intro);

    // allow basic inline formatting
    $allowed = [
      'a' => ['href'=>[], 'title'=>[], 'target'=>[], 'rel'=>[]],
      'strong' => [], 'em' => [], 'br' => []
    ];

    if ($intro !== '') {
      echo '<p class="section-description">'. wp_kses($intro, $allowed) .'</p>';
    }
  }
  ?>
</div>

    <div class="menu-info">
<?php
  $menu_allergen = get_field('menu_allergen'); // WYSIWYG or textarea
  if ($menu_allergen) {
    $allergen = preg_replace('/<!--.*?-->/s', '', $menu_allergen);
    $allergen = preg_replace('#</?(p|div)[^>]*>#i', '', $allergen);
    $allergen = trim($allergen);

    $allowed = [
      'a' => ['href'=>[], 'title'=>[], 'target'=>[], 'rel'=>[]],
      'strong' => [], 'em' => [], 'br' => []
    ];

    if ($allergen !== '') {
      echo '<p class="menu-allergen-warning">'. wp_kses($allergen, $allowed) .'</p>';
    }
  }
  ?>

      <div class="menu-icons">
        <div class="menu-labels">
          <?php if ($labels): ?>
            <?php foreach ($labels as $l): ?>
              <span>
                <?php if (!empty($l['url'])): ?>
                  <img src="<?php echo esc_url($l['url']); ?>" alt="<?php echo esc_attr($l['alt']); ?>" class="icon">
                <?php endif; ?>
                <?php echo esc_html($l['text']); ?>
              </span>
            <?php endforeach; ?>
          <?php else: ?>
            <span><img src="<?php echo esc_url($theme_uri . '/assets/src/vegan.png'); ?>" alt="Vegan Icon" class="icon"> Vegan</span>
            <span><img src="<?php echo esc_url($theme_uri . '/assets/src/spicy.png'); ?>" alt="Spicy Icon" class="icon"> Pimenté</span>
          <?php endif; ?>
        </div>

        <div class="menu-delivery-logos">
          <?php if ($delivery): ?>
            <?php foreach ($delivery as $d): ?>
              <?php if (!empty($d['href'])): ?>
                <a href="<?php echo esc_url($d['href']); ?>" target="<?php echo esc_attr($d['target']); ?>" <?php if ($d['rel']) echo 'rel="'.esc_attr($d['rel']).'"'; ?>>
              <?php endif; ?>

                <?php if (!empty($d['url'])): ?>
                  <img src="<?php echo esc_url($d['url']); ?>" alt="<?php echo esc_attr($d['alt']); ?>">
                <?php endif; ?>

              <?php if (!empty($d['href'])): ?></a><?php endif; ?>
            <?php endforeach; ?>
          <?php else: ?>
            <a href="https://deliveroo.fr/fr/menu/bordeaux/bordeaux-centre/asli-indonesia" target="_blank" rel="noopener">
              <img src="<?php echo esc_url($theme_uri . '/assets/src/delivery (1).png'); ?>" alt="Deliveroo Logo">
            </a>
            <a href="https://www.ubereats.com/fr/store/asli-indonesia-bordeaux" target="_blank" rel="noopener">
              <img src="<?php echo esc_url($theme_uri . '/assets/src/delivery (2).png'); ?>" alt="Uber Eats Logo">
            </a>
            <a href="https://wa.me/33982720521" target="_blank" rel="noopener">
              <img src="<?php echo esc_url($theme_uri . '/assets/src/whatsapp.png'); ?>" alt="WhatsApp Logo">
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>



<section class="menu-gallery menu-gallery-entrees">
  <div class="menu-gallery-header-wrapper">
    <div class="menu-gallery-header">
      <h3 class="menu-gallery-title">Entrées</h3>
    </div>
  </div>
	 <!-- Entrées -->
	<div class="menu-gallery-list">
	  <?php carte_menu_items_by_term('entrees'); ?>
	</div>

  <button class="menu-view-all-button" type="button">Voir tous les entrées</button>
</section>

<section class="menu-gallery menu-gallery-plats">
  <div class="menu-gallery-header-wrapper">
    <div class="menu-gallery-header">
      <h3 class="menu-gallery-title">Plats</h3>
    </div>
  </div>
	<!-- Plats -->
	<div class="menu-gallery-list">
	  <?php carte_menu_items_by_term('plats'); ?>
	</div>
  <button class="menu-view-all-button" type="button">Voir tous les plats</button>
</section>

<section class="menu-gallery menu-gallery-desserts">
  <div class="menu-gallery-header-wrapper">
    <div class="menu-gallery-header">
      <h3 class="menu-gallery-title">Desserts</h3>
    </div>
  </div>
		<!-- Desserts -->
	<div class="menu-gallery-list">
	  <?php carte_menu_items_by_term('desserts'); ?>
	</div>
  <button class="menu-view-all-button" type="button">Voir tous les desserts</button>
</section>

<section class="menu-gallery-boissons">
  <div class="menu-gallery-header-wrapper">
    <div class="menu-gallery-header">
      <h3 class="menu-gallery-title">Boissons</h3>
    </div>
  </div>
	<!-- Boissons (keeps your compact layout + container class) -->
	<div class="menu-gallery-list-boissons">
	  <?php carte_menu_items_by_term('boissons', 'drink'); ?>
	</div>

</section>

<!-- Decorative Flower (left) -->
<div class="deco-2">
  <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/bungabatik2.png'); ?>" alt="Decoration Flower 2" class="deco-flower-2-left">
</div>

<section class="menu-gallery-special">
  <div class="menu-gallery-special-header-wrapper">
    <div class="menu-gallery-special-header">
      <h3 class="menu-gallery-special-title">Plat Spécial</h3>
    </div>
  </div>
  <div class="menu-special-item">
    <p class="menu-special-item-description">Uniquement disponible en commande H-7 jours à l'avance.</p>
  </div>
  <div class="menu-gallery-special-list">
    <article class="menu-special-item">
      <div class="menu-special-item-image-wrapper">
        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/menu (13).png'); ?>" alt="Special Item 1" class="menu-special-image">
      </div>
      <div class="menu-special-item-content">
        <div class="menu-special-item-details">
          <h3 class="menu-special-item-title">Nasi Tumpeng</h3>
          <p class="menu-special-item-price">À partir de €12.00 par personne</p>
          <p class="menu-special-item-portion">Portion: 1 cône de riz + 3 accompagnements</p>
          <p class="menu-special-item-allergies">Allergènes: Gluten, Fruits à coque</p>
        </div>
        <p class="menu-special-item-description">Un délicieux plat indonésien à partager jusqu’à 20 personnes, consistant en un cône de riz accompagné de légumes, viandes et divers condiments. Il est traditionnellement présenté lors d'un selamatan, repas cérémoniel destiné à célébrer un événement. Le riz est coloré de jaune avec du kunyit ou curcuma.</p>
      </div>
    </article>
  </div>
</section>

<?php get_footer(); ?>