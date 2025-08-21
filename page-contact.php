<?php
/* Template Name: Contact Page */
get_header(); ?>

<!-- Decorative Flower (right) -->
<div class="deco-1">
  <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/bungabatik1.png'); ?>" alt="Decoration Flower 1" class="deco-flower-1-right">
</div>

<?php
$title = get_field('contact_title') ?: 'Contactez-nous';
$d1    = get_field('contact_desc_1');
$d2    = get_field('contact_desc_2');

if (!function_exists('mp_one_p')) {
  function mp_one_p($html, $class = 'section-description'){
    if (!$html) return '';
    $html = preg_replace('/<!--.*?-->/s', '', $html);       // remove Gutenberg comments
    $html = preg_replace('#</?(p|div)[^>]*>#i', '', $html); // strip p/div wrappers
    $html = trim($html);
    $allowed = [
      'a' => ['href'=>[], 'title'=>[], 'target'=>[], 'rel'=>[]],
      'strong'=>[], 'em'=>[], 'br'=>[]
    ];
    return $html !== '' ? '<p class="'.esc_attr($class).'">'. wp_kses($html, $allowed) .'</p>' : '';
  }
}
?>

<section class="section-model-basic">
  <div class="section-container">
    <div class="section-text">
      <h2 class="section-title"><?php echo esc_html($title); ?></h2>
      <?php echo mp_one_p($d1); ?>
      <?php echo mp_one_p($d2); ?>
    </div>
  </div>
</section>


<section class="section-model-basic">
  <div class="contact-form">
 	<div class="contact-form">
  <?php
    $sc = get_field('contact_form_shortcode');
    if ($sc) {
      echo do_shortcode($sc);
    } else {
      echo '<p class="section-description">Ajoutez un shortcode de formulaire dans ACF → Form Shortcode.</p>';
    }
  ?>
</div>
</section>

<section class="section-model-basic">
  <div class="section-container">
    <div class="section-text">
      <p class="section-description">Si votre demande concerne une commande en livraison, merci d'adresser une réclamation directement via le service utilisé : Deliveroo ou UberEats.</p>
      <div class="menu-delivery-logos">
        <a href="https://deliveroo.fr/fr/menu/bordeaux/bordeaux-centre/asli-indonesia" target="_blank" rel="noopener">
          <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/delivery (1).png'); ?>" alt="Deliveroo Logo">
        </a>
        <a href="https://www.ubereats.com/fr/store/asli-indonesia-bordeaux" target="_blank" rel="noopener">
          <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/delivery (2).png'); ?>" alt="Uber Eats Logo">
        </a>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>