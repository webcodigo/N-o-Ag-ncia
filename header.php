<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Pular para o conteúdo', 'naoeagencia' ); ?></a>

<?php
$custom_logo_url = naoeagencia_get_option( 'custom_logo_url' );
?>

<header class="site-header">
	<div class="site-shell site-header__meta">
		<p><?php echo esc_html( wp_date( 'j \d\e F \d\e Y' ) ); ?></p>
		<p><?php esc_html_e( 'Edição digital em tempo real', 'naoeagencia' ); ?></p>
		<p><?php esc_html_e( 'Atualizado continuamente', 'naoeagencia' ); ?></p>
	</div>
	<div class="site-shell site-header__inner">
		<div class="site-branding">
			<p class="site-kicker"><?php esc_html_e( 'Jornalismo digital independente', 'naoeagencia' ); ?></p>
			<?php if ( ! empty( $custom_logo_url ) ) : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link" rel="home">
					<img src="<?php echo esc_url( $custom_logo_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
				</a>
			<?php elseif ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php endif; ?>
			<?php if ( get_bloginfo( 'description' ) ) : ?>
				<p class="site-description"><?php bloginfo( 'description' ); ?></p>
			<?php endif; ?>
		</div>

		<div class="header-tools">
			<nav class="main-navigation" aria-label="<?php esc_attr_e( 'Menu principal', 'naoeagencia' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
						'menu_class'     => 'primary-menu',
						'container'      => false,
						'depth'          => 3,
						'fallback_cb'    => 'wp_page_menu',
					)
				);
				?>
			</nav>

			<div class="header-search">
				<?php get_search_form(); ?>
			</div>
		</div>
	</div>
</header>
