<?php
/**
 * Theme functions and definitions.
 *
 * @package NaoeAgencia
 */

if ( ! isset( $content_width ) ) {
	$content_width = 860;
}

if ( ! function_exists( 'naoeagencia_setup' ) ) :
	/**
	 * Register theme supports and menus.
	 */
	function naoeagencia_setup() {
		load_theme_textdomain( 'naoeagencia', get_template_directory() . '/languages' );

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'custom-logo', array( 'flex-width' => true, 'flex-height' => true ) );
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		register_nav_menus(
			array(
				'menu-1'      => esc_html__( 'Menu principal', 'naoeagencia' ),
				'footer-menu' => esc_html__( 'Menu do rodapé', 'naoeagencia' ),
				'social-menu' => esc_html__( 'Redes sociais', 'naoeagencia' ),
			)
		);

		add_image_size( 'naoeagencia-hero', 1600, 900, true );
		add_image_size( 'naoeagencia-card', 800, 520, true );
	}
endif;
add_action( 'after_setup_theme', 'naoeagencia_setup' );

/**
 * Enqueue theme stylesheet.
 */
function naoeagencia_scripts() {
	wp_enqueue_style( 'naoeagencia-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'naoeagencia_scripts' );

/**
 * Register widget areas.
 */
function naoeagencia_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar principal', 'naoeagencia' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Widgets exibidos em posts, páginas e arquivos.', 'naoeagencia' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Home: faixa superior', 'naoeagencia' ),
			'id'            => 'home-top',
			'description'   => esc_html__( 'Widgets exibidos abaixo do destaque principal da home.', 'naoeagencia' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Home: faixa inferior', 'naoeagencia' ),
			'id'            => 'home-bottom',
			'description'   => esc_html__( 'Widgets exibidos após o fluxo principal da home.', 'naoeagencia' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'naoeagencia_widgets_init' );

/**
 * Build category choices for admin fields.
 *
 * @return array
 */
function naoeagencia_get_category_choices() {
	$choices    = array( 0 => esc_html__( 'Desativada', 'naoeagencia' ) );
	$categories = get_categories( array( 'hide_empty' => false ) );

	foreach ( $categories as $category ) {
		$choices[ $category->term_id ] = $category->name;
	}

	return $choices;
}

/**
 * Add theme classes.
 *
 * @param array $classes Current body classes.
 * @return array
 */
function naoeagencia_body_classes( $classes ) {
	if ( is_singular() ) {
		$classes[] = 'is-singular-view';
	}

	if ( is_home() || is_front_page() ) {
		$classes[] = 'is-editorial-home';
	}

	return $classes;
}
add_filter( 'body_class', 'naoeagencia_body_classes' );

/**
 * Make excerpts more compact for editorial cards.
 *
 * @return int
 */
function naoeagencia_excerpt_length() {
	return 22;
}
add_filter( 'excerpt_length', 'naoeagencia_excerpt_length', 999 );

/**
 * Keep excerpt suffix clean.
 *
 * @return string
 */
function naoeagencia_excerpt_more() {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'naoeagencia_excerpt_more' );

/**
 * Custom options page.
 */
function naoe_tema_add_admin_menu() {
	add_menu_page(
		'Não é Tema - Configurações',
		'Não é Tema',
		'manage_options',
		'naoe-tema',
		'naoe_tema_options_page',
		'dashicons-art',
		2
	);
}
add_action( 'admin_menu', 'naoe_tema_add_admin_menu' );

/**
 * Register theme settings.
 */
function naoe_tema_settings_init() {
	register_setting(
		'naoe_tema_options',
		'naoe_tema_settings',
		array(
			'sanitize_callback' => 'naoe_tema_sanitize_settings',
			'default'           => array(),
		)
	);

	add_settings_section(
		'naoe_tema_general_section',
		__( 'Configurações gerais', 'naoeagencia' ),
		'__return_empty_string',
		'naoe-tema'
	);

	add_settings_field( 'custom_logo_url', __( 'URL do logo', 'naoeagencia' ), 'naoe_tema_input_render', 'naoe-tema', 'naoe_tema_general_section', array( 'id' => 'custom_logo_url', 'desc' => 'Cole a URL de uma imagem otimizada para usar como logo.' ) );
	add_settings_field( 'header_meta_date', __( 'Texto da data no topo', 'naoeagencia' ), 'naoe_tema_input_render', 'naoe-tema', 'naoe_tema_general_section', array( 'id' => 'header_meta_date', 'desc' => 'Exemplo: 1 de abril de 2026' ) );
	add_settings_field( 'header_meta_edition', __( 'Texto editorial do topo', 'naoeagencia' ), 'naoe_tema_input_render', 'naoe-tema', 'naoe_tema_general_section', array( 'id' => 'header_meta_edition', 'desc' => 'Exemplo: Edição digital em tempo real' ) );
	add_settings_field( 'header_meta_status', __( 'Texto de status do topo', 'naoeagencia' ), 'naoe_tema_input_render', 'naoe-tema', 'naoe_tema_general_section', array( 'id' => 'header_meta_status', 'desc' => 'Exemplo: Atualizado continuamente' ) );

	add_settings_section(
		'naoe_tema_home_section',
		__( 'Home editorial', 'naoeagencia' ),
		'__return_empty_string',
		'naoe-tema'
	);

	add_settings_field( 'home_kicker', __( 'Kicker da home', 'naoeagencia' ), 'naoe_tema_input_render', 'naoe-tema', 'naoe_tema_home_section', array( 'id' => 'home_kicker' ) );
	add_settings_field( 'home_title', __( 'Título principal da home', 'naoeagencia' ), 'naoe_tema_input_render', 'naoe-tema', 'naoe_tema_home_section', array( 'id' => 'home_title' ) );
	add_settings_field( 'home_description', __( 'Texto de apoio da home', 'naoeagencia' ), 'naoe_tema_textarea_render', 'naoe-tema', 'naoe_tema_home_section', array( 'id' => 'home_description' ) );
	add_settings_field( 'featured_tag', __( 'Tag do destaque principal', 'naoeagencia' ), 'naoe_tema_tag_render', 'naoe-tema', 'naoe_tema_home_section', array( 'id' => 'featured_tag', 'desc' => 'Selecione a tag usada para puxar a matéria principal da home.' ) );
	add_settings_field( 'ticker_label', __( 'Rótulo do ticker', 'naoeagencia' ), 'naoe_tema_input_render', 'naoe-tema', 'naoe_tema_home_section', array( 'id' => 'ticker_label' ) );
	add_settings_field( 'ticker_category', __( 'Categoria do ticker', 'naoeagencia' ), 'naoe_tema_category_render', 'naoe-tema', 'naoe_tema_home_section', array( 'id' => 'ticker_category', 'desc' => 'Use uma categoria específica para a faixa de assuntos rápidos do topo.' ) );
	add_settings_field( 'highlights_label', __( 'Rótulo da faixa de destaques', 'naoeagencia' ), 'naoe_tema_input_render', 'naoe-tema', 'naoe_tema_home_section', array( 'id' => 'highlights_label' ) );
	add_settings_field( 'highlights_title', __( 'Título da faixa de destaques', 'naoeagencia' ), 'naoe_tema_input_render', 'naoe-tema', 'naoe_tema_home_section', array( 'id' => 'highlights_title' ) );
	add_settings_field( 'highlights_category', __( 'Categoria da faixa de destaques', 'naoeagencia' ), 'naoe_tema_category_render', 'naoe-tema', 'naoe_tema_home_section', array( 'id' => 'highlights_category', 'desc' => 'Cada espaço da home pode apontar para uma editoria diferente.' ) );
	add_settings_field( 'home_section_1_title', __( 'Título da faixa editorial 1', 'naoeagencia' ), 'naoe_tema_input_render', 'naoe-tema', 'naoe_tema_home_section', array( 'id' => 'home_section_1_title' ) );
	add_settings_field( 'home_section_1_category', __( 'Categoria da faixa editorial 1', 'naoeagencia' ), 'naoe_tema_category_render', 'naoe-tema', 'naoe_tema_home_section', array( 'id' => 'home_section_1_category' ) );
	add_settings_field( 'home_section_2_title', __( 'Título da faixa editorial 2', 'naoeagencia' ), 'naoe_tema_input_render', 'naoe-tema', 'naoe_tema_home_section', array( 'id' => 'home_section_2_title' ) );
	add_settings_field( 'home_section_2_category', __( 'Categoria da faixa editorial 2', 'naoeagencia' ), 'naoe_tema_category_render', 'naoe-tema', 'naoe_tema_home_section', array( 'id' => 'home_section_2_category' ) );
	add_settings_field( 'latest_label', __( 'Rótulo do fluxo principal', 'naoeagencia' ), 'naoe_tema_input_render', 'naoe-tema', 'naoe_tema_home_section', array( 'id' => 'latest_label' ) );
	add_settings_field( 'latest_title', __( 'Título do fluxo principal', 'naoeagencia' ), 'naoe_tema_input_render', 'naoe-tema', 'naoe_tema_home_section', array( 'id' => 'latest_title' ) );
	add_settings_field( 'latest_category', __( 'Categoria do fluxo principal', 'naoeagencia' ), 'naoe_tema_category_render', 'naoe-tema', 'naoe_tema_home_section', array( 'id' => 'latest_category', 'desc' => 'Se deixar em “Todas as categorias”, o fluxo exibirá o mix editorial completo.' ) );

	add_settings_section(
		'naoe_tema_performance_section',
		__( 'Otimizações', 'naoeagencia' ),
		'__return_empty_string',
		'naoe-tema'
	);

	add_settings_field( 'disable_emojis', __( 'Desativar emojis do WordPress', 'naoeagencia' ), 'naoe_tema_checkbox_render', 'naoe-tema', 'naoe_tema_performance_section', array( 'id' => 'disable_emojis', 'desc' => 'Remove scripts e estilos nativos de emoji.' ) );
	add_settings_field( 'disable_embeds', __( 'Desativar embeds nativos', 'naoeagencia' ), 'naoe_tema_checkbox_render', 'naoe-tema', 'naoe_tema_performance_section', array( 'id' => 'disable_embeds', 'desc' => 'Remove o JavaScript de embed do WordPress quando não for necessário.' ) );
	add_settings_field( 'disable_global_styles', __( 'Desativar estilos globais do core', 'naoeagencia' ), 'naoe_tema_checkbox_render', 'naoe-tema', 'naoe_tema_performance_section', array( 'id' => 'disable_global_styles', 'desc' => 'Mantém o CSS do tema como fonte principal do visual.' ) );

	add_settings_section(
		'naoe_tema_ads_section',
		__( 'Configurações de anúncios', 'naoeagencia' ),
		'__return_empty_string',
		'naoe-tema'
	);

	add_settings_field( 'ad_top', __( 'Anúncio: início do post', 'naoeagencia' ), 'naoe_tema_textarea_render', 'naoe-tema', 'naoe_tema_ads_section', array( 'id' => 'ad_top' ) );
	add_settings_field( 'ad_middle', __( 'Anúncio: meio do post', 'naoeagencia' ), 'naoe_tema_textarea_render', 'naoe-tema', 'naoe_tema_ads_section', array( 'id' => 'ad_middle' ) );
	add_settings_field( 'ad_bottom', __( 'Anúncio: fim do post', 'naoeagencia' ), 'naoe_tema_textarea_render', 'naoe-tema', 'naoe_tema_ads_section', array( 'id' => 'ad_bottom' ) );
}
add_action( 'admin_init', 'naoe_tema_settings_init' );

/**
 * Sanitize theme settings.
 *
 * @param array $input Raw values.
 * @return array
 */
function naoe_tema_sanitize_settings( $input ) {
	$sanitized = array();

	$sanitized['custom_logo_url'] = empty( $input['custom_logo_url'] ) ? '' : esc_url_raw( $input['custom_logo_url'] );
	$sanitized['featured_tag']    = empty( $input['featured_tag'] ) ? 0 : absint( $input['featured_tag'] );

	foreach ( array( 'header_meta_date', 'header_meta_edition', 'header_meta_status', 'home_kicker', 'home_title', 'ticker_label', 'highlights_label', 'highlights_title', 'home_section_1_title', 'home_section_2_title', 'latest_label', 'latest_title' ) as $field ) {
		$sanitized[ $field ] = empty( $input[ $field ] ) ? '' : sanitize_text_field( $input[ $field ] );
	}

	$sanitized['home_description'] = empty( $input['home_description'] ) ? '' : sanitize_textarea_field( $input['home_description'] );

	foreach ( array( 'ticker_category', 'highlights_category', 'home_section_1_category', 'home_section_2_category', 'latest_category' ) as $field ) {
		$sanitized[ $field ] = empty( $input[ $field ] ) ? 0 : absint( $input[ $field ] );
	}

	foreach ( array( 'disable_emojis', 'disable_embeds', 'disable_global_styles' ) as $field ) {
		$sanitized[ $field ] = empty( $input[ $field ] ) ? 0 : 1;
	}

	foreach ( array( 'ad_top', 'ad_middle', 'ad_bottom' ) as $field ) {
		if ( empty( $input[ $field ] ) ) {
			$sanitized[ $field ] = '';
			continue;
		}

		$sanitized[ $field ] = current_user_can( 'unfiltered_html' ) ? $input[ $field ] : wp_kses_post( $input[ $field ] );
	}

	return $sanitized;
}

/**
 * Render textarea field.
 *
 * @param array $args Field arguments.
 */
function naoe_tema_textarea_render( $args ) {
	$options = get_option( 'naoe_tema_settings', array() );
	$value   = isset( $options[ $args['id'] ] ) ? $options[ $args['id'] ] : '';

	echo '<textarea name="naoe_tema_settings[' . esc_attr( $args['id'] ) . ']" rows="6" class="large-text">' . esc_textarea( $value ) . '</textarea>';
}

/**
 * Render checkbox field.
 *
 * @param array $args Field arguments.
 */
function naoe_tema_checkbox_render( $args ) {
	$options = get_option( 'naoe_tema_settings', array() );
	$checked = ! empty( $options[ $args['id'] ] );

	echo '<label><input type="checkbox" name="naoe_tema_settings[' . esc_attr( $args['id'] ) . ']" value="1" ' . checked( $checked, true, false ) . '> ' . esc_html__( 'Ativar', 'naoeagencia' ) . '</label>';

	if ( isset( $args['desc'] ) ) {
		echo '<p class="description">' . esc_html( $args['desc'] ) . '</p>';
	}
}

/**
 * Render category select field.
 *
 * @param array $args Field arguments.
 */
function naoe_tema_category_render( $args ) {
	$options    = get_option( 'naoe_tema_settings', array() );
	$current_id = isset( $options[ $args['id'] ] ) ? absint( $options[ $args['id'] ] ) : 0;
	$categories = get_categories( array( 'hide_empty' => false ) );

	echo '<select name="naoe_tema_settings[' . esc_attr( $args['id'] ) . ']" class="regular-text">';
	echo '<option value="0">' . esc_html__( 'Todas as categorias', 'naoeagencia' ) . '</option>';

	foreach ( $categories as $category ) {
		printf(
			'<option value="%1$d" %2$s>%3$s</option>',
			absint( $category->term_id ),
			selected( $current_id, $category->term_id, false ),
			esc_html( $category->name )
		);
	}

	echo '</select>';

	if ( isset( $args['desc'] ) ) {
		echo '<p class="description">' . esc_html( $args['desc'] ) . '</p>';
	}
}

/**
 * Render tag select field.
 *
 * @param array $args Field arguments.
 */
function naoe_tema_tag_render( $args ) {
	$options    = get_option( 'naoe_tema_settings', array() );
	$current_id = isset( $options[ $args['id'] ] ) ? absint( $options[ $args['id'] ] ) : 0;
	$tags       = get_tags( array( 'hide_empty' => false ) );

	echo '<select name="naoe_tema_settings[' . esc_attr( $args['id'] ) . ']" class="regular-text">';
	echo '<option value="0">' . esc_html__( 'Todas as tags', 'naoeagencia' ) . '</option>';

	foreach ( $tags as $tag ) {
		printf(
			'<option value="%1$d" %2$s>%3$s</option>',
			absint( $tag->term_id ),
			selected( $current_id, $tag->term_id, false ),
			esc_html( $tag->name )
		);
	}

	echo '</select>';

	if ( isset( $args['desc'] ) ) {
		echo '<p class="description">' . esc_html( $args['desc'] ) . '</p>';
	}
}

/**
 * Render text input field.
 *
 * @param array $args Field arguments.
 */
function naoe_tema_input_render( $args ) {
	$options = get_option( 'naoe_tema_settings', array() );
	$value   = isset( $options[ $args['id'] ] ) ? $options[ $args['id'] ] : '';

	echo '<input type="text" name="naoe_tema_settings[' . esc_attr( $args['id'] ) . ']" value="' . esc_attr( $value ) . '" class="regular-text" />';

	if ( isset( $args['desc'] ) ) {
		echo '<p class="description">' . esc_html( $args['desc'] ) . '</p>';
	}
}

/**
 * Render admin page.
 */
function naoe_tema_options_page() {
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Painel do tema', 'naoeagencia' ); ?></h1>
		<form action="options.php" method="post">
			<?php
			settings_fields( 'naoe_tema_options' );
			do_settings_sections( 'naoe-tema' );
			submit_button( __( 'Salvar configurações', 'naoeagencia' ) );
			?>
		</form>
	</div>
	<?php
}

/**
 * Get theme option by key.
 *
 * @param string $key Option key.
 * @param mixed  $default Default value.
 * @return mixed
 */
function naoeagencia_get_option( $key, $default = '' ) {
	$options = get_option( 'naoe_tema_settings', array() );

	return isset( $options[ $key ] ) ? $options[ $key ] : $default;
}

/**
 * Check if an option is enabled.
 *
 * @param string $key Option key.
 * @return bool
 */
function naoeagencia_option_enabled( $key ) {
	return (bool) naoeagencia_get_option( $key, 0 );
}

/**
 * Print visible image link label.
 *
 * @param string $title Post title.
 * @return void
 */
function naoeagencia_media_badge( $title ) {
	?>
	<span class="story-media-badge">
		<span class="story-media-badge__label"><?php esc_html_e( 'Abrir matéria', 'naoeagencia' ); ?></span>
		<span class="story-media-badge__title"><?php echo esc_html( wp_trim_words( $title, 7, '...' ) ); ?></span>
	</span>
	<?php
}

/**
 * Render post media with visible access label.
 *
 * @param string $size Image size.
 * @param string $class CSS class.
 * @param array  $attrs Image attributes.
 * @return void
 */
function naoeagencia_post_media( $size, $class = 'story-card__media', $attrs = array() ) {
	if ( ! has_post_thumbnail() ) {
		return;
	}
	?>
	<a class="<?php echo esc_attr( $class ); ?>" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Acessar: %s', 'naoeagencia' ), get_the_title() ) ); ?>">
		<?php the_post_thumbnail( $size, $attrs ); ?>
		<?php naoeagencia_media_badge( get_the_title() ); ?>
	</a>
	<?php
}

/**
 * Get option with a fallback default.
 *
 * @param string $key Option key.
 * @param mixed  $default Default value.
 * @return mixed
 */
function naoeagencia_get_editorial_setting( $key, $default = '' ) {
	$value = naoeagencia_get_option( $key, '' );

	return '' === $value ? $default : $value;
}

/**
 * Print readable category list.
 */
function naoeagencia_the_category_list() {
	$categories = get_the_category_list( ', ' );

	if ( $categories ) {
		echo wp_kses_post( $categories );
		return;
	}

	echo esc_html__( 'Sem categoria', 'naoeagencia' );
}

/**
 * Print post meta.
 */
function naoeagencia_entry_meta() {
	?>
	<div class="entry-meta">
		<span><?php echo esc_html( get_the_date() ); ?></span>
		<span><?php echo esc_html( get_the_author() ); ?></span>
		<span><?php echo esc_html( naoeagencia_get_read_time() ); ?></span>
	</div>
	<?php
}

/**
 * Estimate reading time.
 *
 * @return string
 */
function naoeagencia_get_read_time() {
	$content    = trim( wp_strip_all_tags( get_post_field( 'post_content', get_the_ID() ) ) );
	$words      = preg_split( '/[\s]+/u', $content, -1, PREG_SPLIT_NO_EMPTY );
	$word_count = max( 1, is_array( $words ) ? count( $words ) : 1 );
	$minutes    = max( 1, (int) ceil( $word_count / 220 ) );

	/* translators: %s: reading time in minutes. */
	return sprintf( esc_html__( '%s min de leitura', 'naoeagencia' ), $minutes );
}

/**
 * Get single post share URL.
 *
 * @param string $network Social network.
 * @return string
 */
function naoeagencia_get_share_url( $network ) {
	$permalink = rawurlencode( get_permalink() );
	$title     = rawurlencode( get_the_title() );

	switch ( $network ) {
		case 'facebook':
			return 'https://www.facebook.com/sharer/sharer.php?u=' . $permalink;
		case 'linkedin':
			return 'https://www.linkedin.com/shareArticle?mini=true&url=' . $permalink . '&title=' . $title;
		case 'whatsapp':
			return 'https://api.whatsapp.com/send?text=' . $title . '%20' . $permalink;
		default:
			return 'https://twitter.com/intent/tweet?text=' . $title . '&url=' . $permalink;
	}
}

/**
 * Render a compact editorial section for a category.
 *
 * @param int    $category_id Category ID.
 * @param string $title Section title.
 * @return void
 */
function naoeagencia_render_home_section( $category_id, $title ) {
	$category_id = absint( $category_id );

	if ( ! $category_id ) {
		return;
	}

	$category = get_category( $category_id );

	if ( ! $category || is_wp_error( $category ) ) {
		return;
	}

	$query = new WP_Query(
		array(
			'posts_per_page'      => 4,
			'ignore_sticky_posts' => true,
			'cat'                 => $category_id,
		)
	);

	if ( ! $query->have_posts() ) {
		return;
	}
	?>
	<section class="home-section home-section--category">
		<div class="section-heading section-heading--split">
			<div>
				<p class="section-label"><?php echo esc_html( $category->name ); ?></p>
				<h2><?php echo esc_html( $title ); ?></h2>
			</div>
			<a class="button-link" href="<?php echo esc_url( get_category_link( $category_id ) ); ?>"><?php esc_html_e( 'Ver tudo', 'naoeagencia' ); ?></a>
		</div>

		<div class="story-grid story-grid--feature">
			<?php
			while ( $query->have_posts() ) :
				$query->the_post();
				?>
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
	</section>
	<?php
}

/**
 * Apply theme optimization settings.
 *
 * @return void
 */
function naoeagencia_apply_optimizations() {
	if ( naoeagencia_option_enabled( 'disable_emojis' ) ) {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	}

	if ( naoeagencia_option_enabled( 'disable_embeds' ) ) {
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
		remove_action( 'wp_head', 'wp_oembed_add_host_js' );
		remove_action( 'rest_api_init', 'wp_oembed_register_route' );
		remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
		remove_action( 'template_redirect', 'rest_output_link_header', 11 );
		remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
	}

	if ( naoeagencia_option_enabled( 'disable_global_styles' ) ) {
		remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
		remove_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );
		remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
	}
}
add_action( 'init', 'naoeagencia_apply_optimizations' );

/**
 * Remove embed script on front end when disabled.
 *
 * @return void
 */
function naoeagencia_maybe_dequeue_embed_script() {
	if ( naoeagencia_option_enabled( 'disable_embeds' ) ) {
		wp_deregister_script( 'wp-embed' );
	}
}
add_action( 'wp_footer', 'naoeagencia_maybe_dequeue_embed_script' );

/**
 * Inject ads into post content.
 *
 * @param string $content Post content.
 * @return string
 */
function naoeagencia_insert_ads_in_content( $content ) {
	if ( ! is_single() || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}

	$top_html    = naoeagencia_get_ad_markup( 'ad_top', 'ad-top' );
	$middle_html = naoeagencia_get_ad_markup( 'ad_middle', 'ad-middle' );
	$bottom_html = naoeagencia_get_ad_markup( 'ad_bottom', 'ad-bottom' );

	if ( $middle_html ) {
		$paragraphs = explode( '</p>', $content );

		if ( count( $paragraphs ) >= 3 ) {
			$paragraphs[1] .= '</p>' . $middle_html;
			$content        = '';

			foreach ( $paragraphs as $index => $paragraph ) {
				if ( trim( $paragraph ) ) {
					$content .= $paragraph;

					if ( $index < count( $paragraphs ) - 1 ) {
						$content .= '</p>';
					}
				}
			}
		} else {
			$content .= $middle_html;
		}
	}

	return $top_html . $content . $bottom_html;
}
add_filter( 'the_content', 'naoeagencia_insert_ads_in_content' );

/**
 * Build ad markup.
 *
 * @param string $key Theme option key.
 * @param string $modifier CSS modifier.
 * @return string
 */
function naoeagencia_get_ad_markup( $key, $modifier ) {
	$ad_code = naoeagencia_get_option( $key, '' );

	if ( empty( $ad_code ) ) {
		return '';
	}

	return '<div class="ad-container ' . esc_attr( $modifier ) . '"><span class="ad-label">' . esc_html__( 'Publicidade', 'naoeagencia' ) . '</span>' . $ad_code . '</div>';
}
