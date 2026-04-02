<?php get_header(); ?>

<main id="content" class="site-shell">
	<section class="empty-state empty-state--full">
		<p class="section-label"><?php esc_html_e( 'Erro 404', 'naoeagencia' ); ?></p>
		<h1><?php esc_html_e( 'A página que você procurou não existe.', 'naoeagencia' ); ?></h1>
		<p><?php esc_html_e( 'Ela pode ter mudado de endereço, sido removida ou digitada incorretamente.', 'naoeagencia' ); ?></p>
		<?php get_search_form(); ?>
		<p><a class="button-link" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Voltar para a home', 'naoeagencia' ); ?></a></p>
	</section>
</main>

<?php get_footer(); ?>
