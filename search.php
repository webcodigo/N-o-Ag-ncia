<?php
get_header();
$layout_class = is_active_sidebar( 'sidebar-1' ) ? 'content-grid' : 'content-grid content-grid--full';
?>

<main id="content" class="site-shell <?php echo esc_attr( $layout_class ); ?>">
	<section class="content-primary">
		<header class="archive-hero">
			<p class="section-label"><?php esc_html_e( 'Busca', 'naoeagencia' ); ?></p>
			<h1 class="archive-title">
				<?php
				printf(
					/* translators: %s: search term. */
					esc_html__( 'Resultados para: %s', 'naoeagencia' ),
					'<span>' . esc_html( get_search_query() ) . '</span>'
				);
				?>
			</h1>
		</header>

		<?php if ( have_posts() ) : ?>
			<div class="story-list">
				<?php while ( have_posts() ) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'story-card story-card--horizontal' ); ?>>
						<?php if ( has_post_thumbnail() ) : ?>
							<a class="story-card__media" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
								<?php the_post_thumbnail( 'naoeagencia-card', array( 'loading' => 'lazy' ) ); ?>
							</a>
						<?php endif; ?>

						<div class="story-card__content">
							<div class="story-card__tax"><?php naoeagencia_the_category_list(); ?></div>
							<h2 class="story-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<?php naoeagencia_entry_meta(); ?>
							<div class="story-card__excerpt"><?php the_excerpt(); ?></div>
						</div>
					</article>
				<?php endwhile; ?>
			</div>

			<div class="pagination-wrap">
				<?php the_posts_pagination(); ?>
			</div>
		<?php else : ?>
			<section class="empty-state">
				<h2><?php esc_html_e( 'Nada encontrado.', 'naoeagencia' ); ?></h2>
				<p><?php esc_html_e( 'Tente buscar por outro termo.', 'naoeagencia' ); ?></p>
				<?php get_search_form(); ?>
			</section>
		<?php endif; ?>
	</section>

	<?php get_sidebar(); ?>
</main>

<?php get_footer(); ?>
