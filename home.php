<?php
get_header();

$featured_tag      = absint( naoeagencia_get_option( 'featured_tag', 0 ) );
$featured_category = absint( naoeagencia_get_option( 'featured_category', 0 ) );
$layout_class      = is_active_sidebar( 'sidebar-1' ) ? 'content-grid content-grid--home' : 'content-grid content-grid--home content-grid--full';
$ticker_label      = naoeagencia_get_editorial_setting( 'ticker_label', __( 'Agora', 'naoeagencia' ) );
$highlights_label  = naoeagencia_get_editorial_setting( 'highlights_label', __( 'Destaques', 'naoeagencia' ) );
$highlights_title  = naoeagencia_get_editorial_setting( 'highlights_title', __( 'O que importa agora', 'naoeagencia' ) );
$latest_label      = naoeagencia_get_editorial_setting( 'latest_label', __( 'Últimas', 'naoeagencia' ) );
$latest_title      = naoeagencia_get_editorial_setting( 'latest_title', __( 'Fluxo editorial', 'naoeagencia' ) );
$section_1_title   = naoeagencia_get_editorial_setting( 'home_section_1_title', __( 'Cobertura em foco', 'naoeagencia' ) );
$section_2_title   = naoeagencia_get_editorial_setting( 'home_section_2_title', __( 'Leituras recomendadas', 'naoeagencia' ) );
$ticker_category   = absint( naoeagencia_get_option( 'ticker_category', 0 ) );
$highlights_cat    = absint( naoeagencia_get_option( 'highlights_category', 0 ) );
$section_1_cat     = absint( naoeagencia_get_option( 'home_section_1_category', 0 ) );
$section_2_cat     = absint( naoeagencia_get_option( 'home_section_2_category', 0 ) );
$latest_cat        = absint( naoeagencia_get_option( 'latest_category', 0 ) );
$hero_args         = array(
	'posts_per_page'      => 1,
	'ignore_sticky_posts' => true,
);

if ( $featured_category ) {
	$hero_args['cat'] = $featured_category;
}

if ( $featured_tag ) {
	$hero_args['tag_id'] = $featured_tag;
	unset( $hero_args['cat'] );
}

$hero_query       = new WP_Query( $hero_args );
$featured_post_id = 0;
$ticker_query     = new WP_Query(
	array(
		'posts_per_page'      => 2,
		'ignore_sticky_posts' => true,
		'post_status'         => 'publish',
	)
);

if ( $ticker_category ) {
	$ticker_query = new WP_Query(
		array(
			'posts_per_page'      => 2,
			'ignore_sticky_posts' => true,
			'post_status'         => 'publish',
			'cat'                 => $ticker_category,
		)
	);
}
?>

<div class="site-shell page-shell">
	<?php get_template_part( 'left-rail' ); ?>

<main id="content" class="feed-center home-layout">
	<?php if ( $ticker_query->have_posts() ) : ?>
	<section class="trend-strip" aria-label="<?php esc_attr_e( 'Últimos destaques', 'naoeagencia' ); ?>">
			<p class="trend-strip__label"><?php echo esc_html( $ticker_label ); ?></p>
			<div class="trend-strip__items">
				<?php while ( $ticker_query->have_posts() ) : $ticker_query->the_post(); ?>
					<a href="<?php the_permalink(); ?>" class="trend-strip__item"><?php the_title(); ?></a>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( $hero_query->have_posts() ) : ?>
		<section class="hero-story">
			<?php while ( $hero_query->have_posts() ) : $hero_query->the_post(); ?>
				<?php $featured_post_id = get_the_ID(); ?>
				<article <?php post_class( 'hero-story__article' ); ?>>
					<div class="hero-story__copy">
						<p class="section-label"><?php naoeagencia_the_category_list(); ?></p>
						<h2 class="hero-story__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<?php naoeagencia_entry_meta(); ?>
						<div class="hero-story__excerpt"><?php the_excerpt(); ?></div>
						<p><a class="button-link button-link--inverse" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Ler matéria', 'naoeagencia' ); ?></a></p>
					</div>

					<?php naoeagencia_post_media( 'naoeagencia-hero', 'hero-story__media', array( 'fetchpriority' => 'high' ) ); ?>
				</article>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		</section>
	<?php endif; ?>

	<?php if ( is_active_sidebar( 'home-top' ) ) : ?>
		<section class="home-widget-row">
			<?php dynamic_sidebar( 'home-top' ); ?>
		</section>
	<?php endif; ?>

	<section class="home-section">
		<div class="section-heading section-heading--split">
			<div>
				<p class="section-label"><?php echo esc_html( $highlights_label ); ?></p>
				<h2><?php echo esc_html( $highlights_title ); ?></h2>
			</div>
		</div>

		<?php
		$highlight_args = array(
			'posts_per_page'      => 6,
			'post__not_in'        => $featured_post_id ? array( $featured_post_id ) : array(),
			'ignore_sticky_posts' => true,
		);

		if ( $highlights_cat ) {
			$highlight_args['cat'] = $highlights_cat;
		}

		$highlight_query = new WP_Query( $highlight_args );
		?>

		<?php if ( $highlight_query->have_posts() ) : ?>
			<div class="story-grid story-grid--feature">
				<?php while ( $highlight_query->have_posts() ) : $highlight_query->the_post(); ?>
					<article <?php post_class( 'story-card' ); ?>>
						<?php naoeagencia_post_media( 'naoeagencia-card', 'story-card__media', array( 'loading' => 'lazy' ) ); ?>

						<div class="story-card__content">
							<div class="story-card__tax"><?php naoeagencia_the_category_list(); ?></div>
							<h3 class="story-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<?php naoeagencia_entry_meta(); ?>
							<div class="story-card__excerpt"><?php the_excerpt(); ?></div>
						</div>
					</article>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			</div>
		<?php endif; ?>
	</section>

	<?php naoeagencia_render_home_section( $section_1_cat, $section_1_title ); ?>
	<?php naoeagencia_render_home_section( $section_2_cat, $section_2_title ); ?>

	<section class="<?php echo esc_attr( $layout_class ); ?>">
		<div class="content-primary content-primary--full">
			<div class="section-heading section-heading--split">
				<div>
					<p class="section-label"><?php echo esc_html( $latest_label ); ?></p>
					<h2><?php echo esc_html( $latest_title ); ?></h2>
				</div>
			</div>

			<?php
			$latest_args = array(
				'posts_per_page'      => get_option( 'posts_per_page' ),
				'post__not_in'        => $featured_post_id ? array( $featured_post_id ) : array(),
				'ignore_sticky_posts' => true,
				'paged'               => max( 1, get_query_var( 'paged' ) ),
			);

			if ( $latest_cat ) {
				$latest_args['cat'] = $latest_cat;
			}

			$latest_query = new WP_Query( $latest_args );
			?>

			<?php if ( $latest_query->have_posts() ) : ?>
				<div class="story-list">
					<?php while ( $latest_query->have_posts() ) : $latest_query->the_post(); ?>
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
					<?php echo wp_kses_post( paginate_links( array( 'total' => $latest_query->max_num_pages ) ) ); ?>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</div>

	</section>

	<?php if ( is_active_sidebar( 'home-bottom' ) ) : ?>
		<section class="home-widget-row">
			<?php dynamic_sidebar( 'home-bottom' ); ?>
		</section>
	<?php endif; ?>
</main>

	<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
