<?php
get_header();
$layout_class = is_active_sidebar( 'sidebar-1' ) ? 'content-grid' : 'content-grid content-grid--full';
?>

<main id="content" class="site-shell <?php echo esc_attr( $layout_class ); ?>">
	<section class="content-primary">
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

	<?php get_sidebar(); ?>
</main>

<?php get_footer(); ?>
