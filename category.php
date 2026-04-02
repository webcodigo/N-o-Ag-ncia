<?php
get_header();

$current_term  = get_queried_object();
$lead_post_ids = array();
$lead_query    = new WP_Query(
	array(
		'posts_per_page'      => 1,
		'ignore_sticky_posts' => true,
		'cat'                 => $current_term->term_id,
		'paged'               => 1,
	)
);
?>

<div class="site-shell page-shell">
	<?php get_template_part( 'left-rail' ); ?>

<main id="content" class="feed-center category-layout">
	<section class="archive-hero archive-hero--editorial">
		<p class="section-label"><?php esc_html_e( 'Categoria', 'naoeagencia' ); ?></p>
		<h1 class="archive-title"><?php single_cat_title(); ?></h1>
		<?php if ( ! empty( $current_term->description ) ) : ?>
			<div class="archive-description"><?php echo esc_html( $current_term->description ); ?></div>
		<?php endif; ?>
	</section>

	<?php if ( ! is_paged() && $lead_query->have_posts() ) : ?>
		<section class="hero-story hero-story--archive">
			<?php while ( $lead_query->have_posts() ) : $lead_query->the_post(); ?>
				<?php $lead_post_ids[] = get_the_ID(); ?>
				<article <?php post_class( 'hero-story__article' ); ?>>
					<div class="hero-story__copy">
						<p class="section-label"><?php esc_html_e( 'Abertura da editoria', 'naoeagencia' ); ?></p>
						<h2 class="hero-story__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<?php naoeagencia_entry_meta(); ?>
						<div class="hero-story__excerpt"><?php the_excerpt(); ?></div>
					</div>

					<?php naoeagencia_post_media( 'naoeagencia-hero', 'hero-story__media', array( 'fetchpriority' => 'high' ) ); ?>
				</article>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		</section>
	<?php endif; ?>

	<section class="content-grid content-grid--full">
		<section class="content-primary content-primary--full">
			<div class="section-heading section-heading--split">
				<div>
					<p class="section-label"><?php esc_html_e( 'Mais desta editoria', 'naoeagencia' ); ?></p>
					<h2><?php esc_html_e( 'Cobertura completa', 'naoeagencia' ); ?></h2>
				</div>
			</div>

			<?php if ( have_posts() ) : ?>
				<div class="story-list">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php if ( in_array( get_the_ID(), $lead_post_ids, true ) ) : ?>
							<?php continue; ?>
						<?php endif; ?>

						<article id="post-<?php the_ID(); ?>" <?php post_class( 'story-card story-card--horizontal' ); ?>>
							<?php naoeagencia_post_media( 'naoeagencia-card', 'story-card__media', array( 'loading' => 'lazy' ) ); ?>

							<div class="story-card__content">
								<div class="story-card__tax"><?php naoeagencia_the_category_list(); ?></div>
								<h3 class="story-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
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
					<h2><?php esc_html_e( 'Nenhuma publicação nesta categoria.', 'naoeagencia' ); ?></h2>
				</section>
			<?php endif; ?>
		</section>

	</section>
</main>

	<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
