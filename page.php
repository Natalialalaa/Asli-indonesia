<?php /* page.php */ get_header(); ?>
<div class="container">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <article <?php post_class(); ?>>
      <h1 class="section-title"><?php the_title(); ?></h1>
      <div class="entry-content">
        <?php the_content(); ?>
      </div>
    </article>
  <?php endwhile; else: ?>
    <p><?php _e('Aucun contenu pour le moment.', 'asli-indonesia'); ?></p>
  <?php endif; ?>
</div>
<?php get_footer(); ?>
