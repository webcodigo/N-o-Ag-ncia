<?php
get_header();
$layout_class = is_active_sidebar( 'sidebar-1' ) ? 'content-grid' : 'content-grid content-grid--full';
?>

<main id="content" class="site-shell <?php echo esc_attr( $layout_class ); ?>">
	<section class="content-primary">
		<header class="archive-hero">
			<p class="section-label"><?php esc_html_e( 'Publicações', 'naoeagencia' ); ?></p>
			<h1 class="archive-title"><?php bloginfo( 'name' ); ?></h1>
			<p class="archive-description"><?php bloginfo( 'description' ); ?></p>
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
				<h2><?php esc_html_e( 'Nenhum conteúdo encontrado.', 'naoeagencia' ); ?></h2>
				<p><?php esc_html_e( 'Publique o primeiro post para começar o portal.', 'naoeagencia' ); ?></p>
			</section>
		<?php endif; ?>
	</section>

	<?php get_sidebar(); ?>
</main>

<?php get_footer(); ?>
