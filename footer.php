<footer class="site-footer">
	<div class="site-shell footer-grid">
		<section class="footer-block">
			<p class="footer-label"><?php esc_html_e( 'Editorial', 'naoeagencia' ); ?></p>
			<h2 class="footer-title"><?php bloginfo( 'name' ); ?></h2>
			<p class="footer-text"><?php bloginfo( 'description' ); ?></p>
		</section>

		<section class="footer-block">
			<p class="footer-label"><?php esc_html_e( 'Navegação', 'naoeagencia' ); ?></p>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer-menu',
					'container'      => false,
					'fallback_cb'    => 'wp_page_menu',
				)
			);
			?>
		</section>

		<section class="footer-block">
			<p class="footer-label"><?php esc_html_e( 'Conecte-se', 'naoeagencia' ); ?></p>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'social-menu',
					'container'      => false,
					'fallback_cb'    => false,
				)
			);
			?>
		</section>
	</div>

	<div class="site-shell site-footer__bottom">
		<p>&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></p>
		<p><?php esc_html_e( 'Tema editorial otimizado para performance e SEO.', 'naoeagencia' ); ?></p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
