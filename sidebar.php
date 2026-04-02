<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<aside class="content-sidebar" aria-label="<?php esc_attr_e( 'Sidebar principal', 'naoeagencia' ); ?>">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</aside>
<?php endif; ?>
