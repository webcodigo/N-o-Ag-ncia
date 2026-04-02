<aside class="left-rail" aria-label="<?php esc_attr_e( 'Navegação editorial', 'naoeagencia' ); ?>">
	<section class="nav-card">
		<p class="nav-title"><?php esc_html_e( 'Navegação', 'naoeagencia' ); ?></p>
		<nav class="rail-navigation" aria-label="<?php esc_attr_e( 'Editorias', 'naoeagencia' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_class'     => 'rail-menu',
					'container'      => false,
					'depth'          => 3,
					'fallback_cb'    => 'wp_page_menu',
				)
			);
			?>
		</nav>
	</section>
</aside>
