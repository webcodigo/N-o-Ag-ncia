<?php
get_header();
?>

<div class="site-shell page-shell">
	<?php get_template_part( 'left-rail' ); ?>

<main id="content" class="feed-center">
	<section class="content-primary content-primary--full">
		<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'page-article' ); ?>>
				<header class="archive-hero">
					<p class="section-label"><?php esc_html_e( 'Página', 'naoeagencia' ); ?></p>
					<h1 class="archive-title"><?php the_title(); ?></h1>
				</header>

				<div class="single-content">
					<?php the_content(); ?>
				</div>
			</article>

			<?php
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			?>
		<?php endwhile; ?>
	</section>
</main>

	<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
