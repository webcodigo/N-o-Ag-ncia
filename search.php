<?php
get_header();
?>

<div class="site-shell page-shell">
	<?php get_template_part( 'left-rail' ); ?>

<main id="content" class="feed-center">
	<section class="content-primary content-primary--full">
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
						<?php naoeagencia_post_media( 'naoeagencia-card', 'story-card__media', array( 'loading' => 'lazy' ) ); ?>

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
</main>

	<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
