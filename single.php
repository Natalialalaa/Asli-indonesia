<?php /* single.php */ get_header(); ?>
<div class="container">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <article <?php post_class('single-article'); ?>>
      <h1 class="section-title"><?php the_title(); ?></h1>
      <p class="news-date"><?php echo esc_html( get_the_date() ); ?></p>

      <div class="news-image-wrapper">
        <?php if (has_post_thumbnail()) {
          the_post_thumbnail('large', ['class' => 'news-image']);
        } ?>
      </div>

      <div class="entry-content">
        <?php the_content(); ?>
      </div>

      <div class="post-meta">
        <div class="cats"><?php the_category(', '); ?></div>
        <div class="tags"><?php the_tags('', ', ', ''); ?></div>
      </div>

      <nav class="post-nav">
        <div class="prev"><?php previous_post_link('%link', '« %title'); ?></div>
        <div class="next"><?php next_post_link('%link', '%title »'); ?></div>
      </nav>

      <?php comments_template(); ?>
    </article>
  <?php endwhile; endif; ?>
</div>
<?php get_footer(); ?>
