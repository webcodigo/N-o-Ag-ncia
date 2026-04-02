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
$header_meta_date = naoeagencia_get_editorial_setting( 'header_meta_date', wp_date( 'j \d\e F \d\e Y' ) );
$header_meta_edition = naoeagencia_get_editorial_setting( 'header_meta_edition', __( 'Edição digital em tempo real', 'naoeagencia' ) );
$header_meta_status = naoeagencia_get_editorial_setting( 'header_meta_status', __( 'Atualizado continuamente', 'naoeagencia' ) );
?>

<header class="site-header">
	<div class="site-shell site-header__meta">
		<p><?php echo esc_html( $header_meta_date ); ?></p>
		<p><?php echo esc_html( $header_meta_edition ); ?></p>
		<p><?php echo esc_html( $header_meta_status ); ?></p>
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
			<div class="header-search">
				<?php get_search_form(); ?>
			</div>
		</div>
	</div>
</header>
