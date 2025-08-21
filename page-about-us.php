<?php
/* Template Name: About Us Page */
wp_enqueue_script('instagram-embed', 'https://www.instagram.com/embed.js', [], null, true);
get_header();
?>

<!-- Decorative Flower (right) -->
<div class="deco-1">
  <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/bungabatik1.png'); ?>" alt="Decoration Flower 1" class="deco-flower-1-right">
</div>

<section class="section-model-basic">
  <div class="section-container">
    <div class="section-text">
		
		<?php $pid = function_exists('get_queried_object_id') ? get_queried_object_id() : 0; ?>

		<h2 class="section-title">
			<?php echo esc_html( get_field('actualites_title', $pid) ?: 'Actualités' ); ?>
		</h2>
		<p class="section-description">
			<?php
			$intro = get_field('actualites_intro', $pid);
			echo $intro ? wp_kses_post($intro) : "Découvrez nos dernières nouvelles et événements.";
			?>
		</p>

	<div class="social-icons">
            <a href="" target="_blank" rel="noopener">
        <img src="http://localhost/asli/wp-content/themes/theme-asli-indonesia/assets/src/logofb.svg" alt="Facebook">
      </a>
      <a href="" target="_blank" rel="noopener">
        <img src="http://localhost/asli/wp-content/themes/theme-asli-indonesia/assets/src/ig.svg" alt="Instagram">
      </a>
          </div>
    </div>
  </div>
</section>

<!-- Instagram feed -->
<section class="section-model-basic">
  <div class="section-container">
    <h3 class="section-title">Instagram</h3>

      <?php
      if ( function_exists('shortcode_exists') && shortcode_exists('instagram-feed') ) {
        echo do_shortcode('[instagram-feed feed=1]');
      } else {
        echo '<!-- instagram-feed shortcode not found. Activate the Instagram Feed plugin. -->';
      }
      ?>
    
  </div>
</section>

<!-- Reviews feed -->
<section class="section-model-basic">
  <div class="section-container">
    <h3 class="section-title">Avis Google</h3>
    <div class="section-reviews-wrapper">
      <?php
      if ( function_exists('shortcode_exists') && shortcode_exists('reviews-feed') ) {
        echo do_shortcode('[trustindex no-registration=google]');
      } else {
        echo '<!-- reviews-feed shortcode not found. Activate the Reviews Feed plugin. -->';
      }
      ?>
    </div>
  </div>
</section>

<?php
// Prepare "see all news" URL before rendering the news section
$see_all_url   = '';
$posts_page_id = (int) get_option('page_for_posts');
if ($posts_page_id) {
  $see_all_url = get_permalink($posts_page_id);
} else {
  $cat = get_category_by_slug('actualites');
  $see_all_url = $cat ? get_category_link($cat->term_id) : home_url('/');
}

// Query last 3 posts
$q = new WP_Query([
  'posts_per_page' => 3,
  // 'category_name' => 'actualites',
]);
?>

<!-- Actualités -->
<section class="section-model-basic">
  <div class="section-container">
    <h3 class="section-title">Actualités</h3>
	
    <?php if ($q->have_posts()) : ?>
      <?php while ($q->have_posts()) : $q->the_post(); ?>
        <article class="news-article">
          <div class="news-image-wrapper">
            <?php if ( has_post_thumbnail() ) {
              the_post_thumbnail('news-thumb', ['class' => 'news-image']);
            } else { ?>
              <img class="news-image" src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/image 22.jpg'); ?>" alt="">
            <?php } ?>
          </div>
          <div class="news-text-wrapper">
            <h4 class="news-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
            <p class="news-date"><?php echo esc_html( get_the_date() ); ?></p>
            <div class="news-content"><?php the_excerpt(); ?></div>
          </div>
          <div class="news-link-wrapper">
            <a class="news-link" href="<?php the_permalink(); ?>"><?php _e('lire plus', 'asli-indonesia'); ?></a>
          </div>
        </article>
      <?php endwhile; wp_reset_postdata(); ?>

    <?php else : ?>
      <p><?php _e('Aucune actualité pour le moment.', 'asli-indonesia'); ?></p>
    <?php endif; ?>

    <div class="news-link-wrapper" style="margin-top:1rem;">
      <a class="news-link" href="<?php echo esc_url($see_all_url); ?>">Voir toutes les actualités</a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
