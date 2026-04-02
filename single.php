<?php get_header(); ?>

<main id="content" class="site-shell single-layout">
	<?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-article' ); ?>>
			<header class="single-hero">
				<div class="single-hero__content">
					<p class="section-label"><?php naoeagencia_the_category_list(); ?></p>
					<h1 class="single-title"><?php the_title(); ?></h1>
					<?php if ( has_excerpt() ) : ?>
						<div class="single-excerpt"><?php the_excerpt(); ?></div>
					<?php endif; ?>
					<?php naoeagencia_entry_meta(); ?>
				</div>

				<?php if ( has_post_thumbnail() ) : ?>
					<div class="single-hero__media">
						<?php the_post_thumbnail( 'naoeagencia-hero', array( 'fetchpriority' => 'high' ) ); ?>
					</div>
				<?php endif; ?>
			</header>

			<div class="single-content-grid">
				<aside class="single-aside">
					<div class="single-aside__box single-aside__box--status">
						<p class="aside-label"><?php esc_html_e( 'Thread editorial', 'naoeagencia' ); ?></p>
						<p class="aside-value"><?php esc_html_e( 'Leitura em blocos rápidos, contexto em profundidade.', 'naoeagencia' ); ?></p>
					</div>

					<div class="single-aside__box">
						<p class="aside-label"><?php esc_html_e( 'Autor', 'naoeagencia' ); ?></p>
						<p class="aside-value"><?php the_author(); ?></p>
					</div>

					<div class="single-aside__box">
						<p class="aside-label"><?php esc_html_e( 'Compartilhe', 'naoeagencia' ); ?></p>
						<div class="share-buttons">
							<a class="share-btn" href="<?php echo esc_url( naoeagencia_get_share_url( 'twitter' ) ); ?>" target="_blank" rel="noopener noreferrer">X</a>
							<a class="share-btn" href="<?php echo esc_url( naoeagencia_get_share_url( 'facebook' ) ); ?>" target="_blank" rel="noopener noreferrer">Fb</a>
							<a class="share-btn" href="<?php echo esc_url( naoeagencia_get_share_url( 'linkedin' ) ); ?>" target="_blank" rel="noopener noreferrer">In</a>
							<a class="share-btn" href="<?php echo esc_url( naoeagencia_get_share_url( 'whatsapp' ) ); ?>" target="_blank" rel="noopener noreferrer">Wa</a>
						</div>
					</div>
				</aside>

				<div class="single-content">
					<?php the_content(); ?>

					<?php
					wp_link_pages(
						array(
							'before' => '<div class="page-links">' . esc_html__( 'Páginas:', 'naoeagencia' ),
							'after'  => '</div>',
						)
					);
					?>
				</div>
			</div>
		</article>

		<section class="single-related">
			<div class="section-heading">
				<p class="section-label"><?php esc_html_e( 'Continue lendo', 'naoeagencia' ); ?></p>
				<h2><?php esc_html_e( 'Mais histórias', 'naoeagencia' ); ?></h2>
			</div>

			<?php
			$related_query = new WP_Query(
				array(
					'posts_per_page'      => 3,
					'post__not_in'        => array( get_the_ID() ),
					'ignore_sticky_posts' => true,
					'category__in'        => wp_get_post_categories( get_the_ID() ),
				)
			);
			?>

			<?php if ( $related_query->have_posts() ) : ?>
				<div class="story-grid">
					<?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
						<article <?php post_class( 'story-card' ); ?>>
							<?php naoeagencia_post_media( 'naoeagencia-card', 'story-card__media', array( 'loading' => 'lazy' ) ); ?>
							<div class="story-card__content">
								<div class="story-card__tax"><?php naoeagencia_the_category_list(); ?></div>
								<h3 class="story-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<?php naoeagencia_entry_meta(); ?>
							</div>
						</article>
					<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>
				</div>
			<?php endif; ?>
		</section>

		<?php
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
		?>
	<?php endwhile; ?>
</main>

<?php get_footer(); ?>
