<?php /* header.php */ ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header>
<div class="promo">
  <div class="promo-text">
    <?php
    $promo = function_exists('get_field') ? get_field('promo_text', 'option') : '';
    echo esc_html( $promo ?: "Promo : une surprise ⭐ pour chaque commande d’un montant minimum de 30 € !" );
    ?>
  </div>
</div>

  <nav>
    <div class="nav-bar">
      <div class="menu-icon">
        <img class="open" src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/open.png'); ?>" alt="Open menu">
        <img class="close" src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/close.png'); ?>" alt="Close menu">
      </div>
      <div class="menu-logo">
  <?php if ( has_custom_logo() ) {
    echo get_custom_logo(); // already includes <a>
  } else { ?>
    <a href="<?php echo esc_url( home_url('/') ); ?>">
      <img class="logo" src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/logo.png'); ?>" alt="<?php bloginfo('name'); ?>">
    </a>
  <?php } ?>
</div>

    </div>

    <div class="nav-menu">
      <?php
		wp_nav_menu([
		  'theme_location' => 'primary',
		  'container'      => false,
		  'menu_class'     => 'menu-list',
		  'menu_id'        => false,
		  'fallback_cb'    => function () {
			echo '<ul class="menu-list">'
			   . '<li><a href="' . esc_url( home_url('/restaurant/') ) . '">Restaurant</a></li>'
			   . '<li><a href="' . esc_url( home_url('/menu/') ) . '">Menu</a></li>'
			   . '<li><a href="' . esc_url( home_url('/about-us/') ) . '">About Us</a></li>'
			   . '<li><a href="' . esc_url( home_url('/contact/') ) . '">Contact</a></li>'
			   . '</ul>';
		  }
		]);

      ?>

      <div class="social-icons">
        <a href="https://www.facebook.com/AsliIndonesiaBordeaux" target="_blank" rel="noopener"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/logofb.svg'); ?>" alt="Facebook Logo"></a>
        <a href="https://www.instagram.com/asliindonesiabordeaux/" target="_blank" rel="noopener"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/ig.svg'); ?>" alt="Instagram Logo"></a>
      </div>
    </div>


	  <div class="menu-language">
	  </div>
  </nav>
</header>
<main>