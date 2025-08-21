<?php /* index.php */ get_header(); ?>
<div class="container">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class('news-article'); ?>>
      <div class="news-image-wrapper">
        <?php if (has_post_thumbnail()) {
          the_post_thumbnail('news-thumb', ['class' => 'news-image']);
        } ?>
      </div>
      <div class="news-text-wrapper">
        <h2 class="news-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <p class="news-date"><?php echo esc_html( get_the_date() ); ?></p>
        <div class="news-content"><?php the_excerpt(); ?></div>
      </div>
      <div class="news-link-wrapper">
        <a class="news-link" href="<?php the_permalink(); ?>"><?php _e('lire plus', 'asli-indonesia'); ?></a>
      </div>
    </article>
  <?php endwhile; else: ?>
    <p><?php _e('Aucun article trouvé.', 'asli-indonesia'); ?></p>
  <?php endif; ?>

  <nav class="pagination">
    <?php the_posts_pagination(['mid_size' => 1, 'prev_text' => '« Précédent', 'next_text' => 'Suivant »']); ?>
  </nav>
</div>
<?php get_footer(); ?>
