<?php /* 404 */ get_header(); ?>
<section class="page-404 section-model-basic">
  <div class="section-container">
    <div class="section-text">
      <h1 class="section-title">404</h1>
      <p class="section-description"><?php _e('Oups ! La page est introuvable.', 'asli-indonesia'); ?></p>
      <a class="cta-button" href="<?php echo esc_url( home_url('/') ); ?>"><?php _e("Retour à l'accueil", 'asli-indonesia'); ?></a>
    </div>
  </div>
</section>
<?php get_footer(); ?>