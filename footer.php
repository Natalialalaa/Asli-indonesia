<?php /* footer.php */ ?>
</main>
<footer>
  <div class="footer-links">
    <?php
    // Use a menu in the footer for easier management
    wp_nav_menu([
      'theme_location' => 'footer',
      'container'      => false,
      'menu_class'     => '',
      'items_wrap'     => '%3$s', // print only <li> to match your flat links
      'fallback_cb'    => function () {
        echo '<a href="#home">Restaurant</a>'
           . '<a href="#menu">Menu</a>'
           . '<a href="#about">About Us</a>'
           . '<a href="#contact">Contact</a>';
      }
    ]);
    ?>
  </div>

  <div class="footer-logo">
    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/logo.png'); ?>" alt="<?php bloginfo('name'); ?>">
    <p>Cuisine Indonésienne</p>
  </div>

  <div class="footer-social-icons">
    <a href="https://www.facebook.com/AsliIndonesiaBordeaux" target="_blank" rel="noopener"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/logofb.svg'); ?>" alt="Facebook Logo"></a>
    <a href="https://www.instagram.com/asliindonesiabordeaux/" target="_blank" rel="noopener"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/ig.svg'); ?>" alt="Instagram Logo"></a>
  </div>

  <div class="footer-hours">
    <p>Mardi - Samedi 12H - 14H30 | 19H - 22H</p>
    <p>Dimanche 12H - 14H30</p>
  </div>

  <div class="divider-break"></div>

  <div class="footer-address">
    <p>Asli Indonesia Restaurant</p>
    <p>158 CR Victor Hugo</p>
    <p>33000 Bordeaux, France</p>
    <p>Tel: +33 5 56 00 00 00</p>
    <p>Email: <a href="mailto:info@asliindonesia.com">info@asliindonesia.com</a></p>
  </div>

  <div class="divider-break"></div>

  <div class="footer-newsletter">
    <p>Subscribe to our newsletter for updates and special offers:</p>
    <!-- Replace this simple form with a plugin shortcode (MailPoet, Newsletter, etc.) -->
    <form action="#" method="post">
      <input type="email" name="email" placeholder="Enter your email" required>
      <button type="submit">Subscribe</button>
    </form>
  </div>

  <div class="footer-terms">
    <p><a href="<?php echo esc_url( home_url('/mention-legal/') ); ?>">Terms of Service | Privacy Policy</a></p>
  </div>

  <div class="footer-legal">
    <p><?php echo date('Y'); ?> &copy; <?php bloginfo('name'); ?></p>
    <p>Website by <a href="https://www.example.com" target="_blank" rel="noopener">Maison Pixel</a></p>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>