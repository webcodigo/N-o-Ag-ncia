<aside class="right-rail" aria-label="<?php esc_attr_e( 'Contexto editorial', 'naoeagencia' ); ?>">
	<section class="rail-card">
		<p class="rail-title"><?php esc_html_e( 'Em alta', 'naoeagencia' ); ?></p>
		<div class="rail-list">
			<?php
			$trending_query = new WP_Query(
				array(
					'posts_per_page'      => 4,
					'ignore_sticky_posts' => true,
				)
			);
			?>
			<?php if ( $trending_query->have_posts() ) : ?>
				<?php while ( $trending_query->have_posts() ) : $trending_query->the_post(); ?>
					<a class="rail-item" href="<?php the_permalink(); ?>">
						<strong><?php the_title(); ?></strong>
						<span><?php echo esc_html( wp_trim_words( get_the_excerpt(), 16 ) ); ?></span>
					</a>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</div>
	</section>

	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div class="content-sidebar" aria-label="<?php esc_attr_e( 'Sidebar principal', 'naoeagencia' ); ?>">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div>
	<?php else : ?>
		<section class="rail-card">
			<p class="rail-title"><?php esc_html_e( 'Editorias', 'naoeagencia' ); ?></p>
			<div class="rail-list">
				<?php foreach ( get_categories( array( 'number' => 5, 'orderby' => 'count', 'order' => 'DESC' ) ) as $category ) : ?>
					<a class="rail-item" href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>">
						<strong><?php echo esc_html( $category->name ); ?></strong>
						<span>
							<?php
							printf(
								/* translators: %s: post count */
								esc_html__( '%s publicações nesta editoria.', 'naoeagencia' ),
								absint( $category->count )
							);
							?>
						</span>
					</a>
				<?php endforeach; ?>
			</div>
		</section>
	<?php endif; ?>
</aside>
