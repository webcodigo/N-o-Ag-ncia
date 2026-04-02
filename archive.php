<?php
get_header();
?>

<div class="site-shell page-shell">
	<?php get_template_part( 'left-rail' ); ?>

<main id="content" class="feed-center">
	<section class="content-primary content-primary--full">
		<header class="archive-hero">
			<p class="section-label"><?php esc_html_e( 'Arquivo', 'naoeagencia' ); ?></p>
			<h1 class="archive-title"><?php the_archive_title(); ?></h1>
			<?php if ( get_the_archive_description() ) : ?>
				<div class="archive-description"><?php the_archive_description(); ?></div>
			<?php endif; ?>
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
				<h2><?php esc_html_e( 'Nenhum resultado neste arquivo.', 'naoeagencia' ); ?></h2>
			</section>
		<?php endif; ?>
	</section>
</main>

	<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
