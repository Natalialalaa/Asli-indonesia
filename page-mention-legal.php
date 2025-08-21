<?php
/* Template Name: Mentions légales */
get_header(); ?>

<section id="legal" class="page-legal section-model-basic">
  <div class="section-container">
    <div class="section-text">
      <h2 class="section-title">Mentions légales</h2>
      <p class="section-description">Dernière mise à jour : <?php echo esc_html( date_i18n( get_option('date_format') ) ); ?></p>
    </div>
  </div>

  <div class="container legal-content">
    <h3>Éditeur du site</h3>
    <p><strong><?php bloginfo('name'); ?></strong> – Asli Indonesia Restaurant<br>
    158 Cr Victor Hugo, 33000 Bordeaux, France<br>
    Email : <a href="mailto:info@asliindonesia.com">info@asliindonesia.com</a></p>

    <h3>Hébergement</h3>
    <p>Ce site est hébergé par : <em>[Nom de l'hébergeur]</em> – <em>[Adresse de l'hébergeur]</em></p>

    <h3>Propriété intellectuelle</h3>
    <p>Les contenus (textes, images, logos) sont la propriété de <?php bloginfo('name'); ?>, sauf mention contraire. 
    Toute reproduction est interdite sans autorisation préalable.</p>

    <h3>Données personnelles</h3>
    <p>Les données recueillies via le formulaire de contact sont utilisées uniquement pour répondre à votre demande. 
    Vous pouvez exercer vos droits (accès, rectification, suppression) en écrivant à <a href="mailto:info@asliindonesia.com">info@asliindonesia.com</a>.</p>

    <h3>Cookies</h3>
    <p>Ce site peut utiliser des cookies de mesure d'audience et de fonctionnalités. Vous pouvez les gérer depuis les 
    réglages de votre navigateur.</p>

    <h3>Responsabilité</h3>
    <p><?php bloginfo('name'); ?> s'efforce d'assurer l'exactitude des informations publiées mais ne saurait être tenue pour responsable 
    des erreurs ou omissions.</p>

    <h3>Crédits</h3>
    <p>Design & développement : <a href="https://www.example.com" target="_blank" rel="noopener">Maison Pixel</a></p>
  </div>
</section>

<?php get_footer(); ?>