<?php

defined('ABSPATH') or die();
class NarTrans_Resource {

	const POST_TYPE = 'resource';

	private static $instance = NULL;

	/**
	 * Constructor
	 */
	function __construct() {

		// Acción registrar CPT
		add_action('init', [$this, 'register_post_type']);

		// Acción registrar taxonomías
		add_action('init', [$this, 'register_taxonomies']);

		// Filtro metaboxes
		add_filter('rwmb_meta_boxes', [$this, 'register_metaboxes'], 10, 1);
	}



	/**
	 * Registra el CPT
	 */
	function register_post_type() {
		$singular_name = __('Recurso', 'nar-trans-data');
		$general_name  = __('Recursos', 'nar-trans-data');

		$args = array(
			'labels' => array(
				'name'               => $general_name,
				'singular_name'      => $singular_name,
				'menu_name'          => $general_name,
				'name_admin_bar'     => $singular_name,
				'add_new'            => __('Añadir nueva', 'nar-trans-data'),
				'add_new_item'       => sprintf(__('Añadir nueva %s', 'nar-trans-data'), $singular_name),
				'new_item'           => sprintf(__('Nueva %s', 'nar-trans-data'), $singular_name),
				'edit_item'          => sprintf(__('Editar %s', 'nar-trans-data'), $singular_name),
				'view_item'          => sprintf(__('Ver %s', 'nar-trans-data'), $singular_name),
				'all_items'          => sprintf(__('Todos los %s', 'nar-trans-data'), $general_name),
				'search_items'       => sprintf(__('Buscar %s', 'nar-trans-data'), $general_name),
				'parent_item_colon'  => sprintf(__('%s superior:', 'nar-trans-data'), $singular_name),
				'not_found'          => sprintf(__('No se ha encontrado %s.', 'nar-trans-data'), $general_name),
				'not_found_in_trash' => sprintf(__('No se ha encontrado %s en la papelera.', 'nar-trans-data'), $general_name),
			),
			'supports' => array(
				'title',
				'editor',
				//'author',
				'thumbnail',
			),
			'public' => true,
			'public_queryable' => false,
			'query_var' => false,
			'rewrite' => [ 'slug' => 'recurso' ],
			'has_archive' => 'recursos',
			'hierarchical' => false,
			'exclude_from_search' => false,
			'capability_type' => 'post',
			'menu_icon' => 'dashicons-id',
			'show_in_rest' => false,
		);

		register_post_type(self::POST_TYPE, $args);
	} // Fín registro cpt


	/**
	 * Registra las taxonomías
	 */
	function register_taxonomies() {

		$singular_name = __('Categoría', 'nar-trans-data');
		$plural_name   = __('Categorías', 'nar-trans-data');
		register_taxonomy('resource_category', self::POST_TYPE, array(
			'hierarchical'      => true,
			'labels'            => array(
				'name'              => $plural_name,
				'singular_name'     => $singular_name,
				'search_items'      => sprintf(__('Buscar %s', 'nar-trans-data'), $singular_name),
				'all_items'         => sprintf(__('Todos los %s', 'nar-trans-data'), $plural_name),
				'parent_item'       => sprintf(__('%s superior', 'nar-trans-data'), $singular_name),
				'parent_item_colon' => sprintf(__('%s superior:', 'nar-trans-data'), $singular_name),
				'edit_item'         => sprintf(__('Editar %s', 'nar-trans-data'), $singular_name),
				'update_item'       => sprintf(__('Actualizar %s', 'nar-trans-data'), $singular_name),
				'add_new_item'      => sprintf(_x('Nuevo %s', 'femenino', 'nar-trans-data'), $singular_name),
				'new_item_name'     => sprintf(_x('Nuevo nombre de %s', 'nar-trans-data'), $singular_name),
				'menu_name'         => $plural_name,
			),
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite' => [ 'slug' => 'categoria-recurso' ],
		));

		$singular_name 	= __('Género', 'nar-trans-data');
		$plural_name 	= __('Géneros', 'nar-trans-data');
		register_taxonomy('resource_genre', self::POST_TYPE, array(
			'hierarchical'      => true,
			'labels'            => array(
				'name'              => $plural_name,
				'singular_name'     => $singular_name,
				'search_items'      => sprintf(__('Buscar %s', 'nar-trans-data'), $singular_name),
				'all_items'         => sprintf(__('Todos los %s', 'nar-trans-data'), $plural_name),
				'parent_item'       => sprintf(__('%s superior', 'nar-trans-data'), $singular_name),
				'parent_item_colon' => sprintf(__('%s superior:', 'nar-trans-data'), $singular_name),
				'edit_item'         => sprintf(__('Editar %s', 'nar-trans-data'), $singular_name),
				'update_item'       => sprintf(__('Actualizar %s', 'nar-trans-data'), $singular_name),
				'add_new_item'      => sprintf(_x('Nuevo %s', 'femenino', 'nar-trans-data'), $singular_name),
				'new_item_name'     => sprintf(_x('Nuevo nombre de %s', 'nar-trans-data'), $singular_name),
				'menu_name'         => $plural_name,
			),
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite' => ['slug' => 'genero'],
		));

		$singular_name 	= __('Tipo de premio', 'nar-trans-data');
		$plural_name 	= __('Tipos de premios', 'nar-trans-data');
		register_taxonomy('resource_adwards_type ', self::POST_TYPE, array(
			'hierarchical'      => true,
			'labels'            => array(
				'name'              => $plural_name,
				'singular_name'     => $singular_name,
				'search_items'      => sprintf(__('Buscar %s', 'nar-trans-data'), $singular_name),
				'all_items'         => sprintf(__('Todos los %s', 'nar-trans-data'), $plural_name),
				'parent_item'       => sprintf(__('%s superior', 'nar-trans-data'), $singular_name),
				'parent_item_colon' => sprintf(__('%s superior:', 'nar-trans-data'), $singular_name),
				'edit_item'         => sprintf(__('Editar %s', 'nar-trans-data'), $singular_name),
				'update_item'       => sprintf(__('Actualizar %s', 'nar-trans-data'), $singular_name),
				'add_new_item'      => sprintf(_x('Nuevo %s', 'femenino', 'nar-trans-data'), $singular_name),
				'new_item_name'     => sprintf(_x('Nuevo nombre de %s', 'nar-trans-data'), $singular_name),
				'menu_name'         => $plural_name,
			),
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
		));

		$singular_name 	= __('Tipo de recurso', 'nar-trans-data');
		$plural_name 	= __('Tipos de recursos', 'nar-trans-data');
		register_taxonomy('resource_type', self::POST_TYPE, array(
			'hierarchical'      => true,
			'labels'            => array(
				'name'              => $plural_name,
				'singular_name'     => $singular_name,
				'search_items'      => sprintf(__('Buscar %s', 'nar-trans-data'), $singular_name),
				'all_items'         => sprintf(__('Todos los %s', 'nar-trans-data'), $plural_name),
				'parent_item'       => sprintf(__('%s superior', 'nar-trans-data'), $singular_name),
				'parent_item_colon' => sprintf(__('%s superior:', 'nar-trans-data'), $singular_name),
				'edit_item'         => sprintf(__('Editar %s', 'nar-trans-data'), $singular_name),
				'update_item'       => sprintf(__('Actualizar %s', 'nar-trans-data'), $singular_name),
				'add_new_item'      => sprintf(_x('Nuevo %s', 'femenino', 'nar-trans-data'), $singular_name),
				'new_item_name'     => sprintf(_x('Nuevo nombre de %s', 'nar-trans-data'), $singular_name),
				'menu_name'         => $plural_name,
			),
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite' => ['slug' => 'tipo-recurso'],
		));

		$singular_name 	= __('Idioma', 'nar-trans-data');
		$plural_name 	= __('Idiomas', 'nar-trans-data');
		register_taxonomy('resource_language', self::POST_TYPE, array(
			'hierarchical'      => true,
			'labels'            => array(
				'name'              => $plural_name,
				'singular_name'     => $singular_name,
				'search_items'      => sprintf(__('Buscar %s', 'nar-trans-data'), $singular_name),
				'all_items'         => sprintf(__('Todos los %s', 'nar-trans-data'), $plural_name),
				'parent_item'       => sprintf(__('%s superior', 'nar-trans-data'), $singular_name),
				'parent_item_colon' => sprintf(__('%s superior:', 'nar-trans-data'), $singular_name),
				'edit_item'         => sprintf(__('Editar %s', 'nar-trans-data'), $singular_name),
				'update_item'       => sprintf(__('Actualizar %s', 'nar-trans-data'), $singular_name),
				'add_new_item'      => sprintf(_x('Nuevo %s', 'femenino', 'nar-trans-data'), $singular_name),
				'new_item_name'     => sprintf(_x('Nuevo nombre de %s', 'nar-trans-data'), $singular_name),
				'menu_name'         => $plural_name,
			),
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite' => ['slug' => 'idioma-recurso'],
		));
	} // Fín taxonomias


	/**
	 * Registrar los campos personalizados
	 */
	function register_metaboxes($meta_boxes) {

		$meta_boxes[] = array(
			'id' 			=> self::POST_TYPE . '_custom_fields',
			'title' 		=> __('Datos personalizados catálogo', 'nar-trans-data'),
			'post_types' 	=> array(self::POST_TYPE),
			'context' 		=> 'advanced',
			'priority' 		=> 'default',
			'autosave' 		=> false,
			'fields' 		=> array(

				[
					'id' 	=> 'id_old',
					'name'	=> 'ID antiguo',
					'type'	=> 'text',
				],
				[
					'id' 	=> 'url',
					'name' 	=> __('URL', 'nar-trans-data'),
					'type' 	=> 'url',
				],
				[
					'id' 	=> 'nationality',
					'name' 	=> __('Nacionalidad', 'nar-trans-data'),
					'type' 	=> 'text',
				],
				[
					'id' 	=> 'credit',
					'name' 	=> __('Creditos', 'nar-trans-data'),
					'type' 	=> 'text',
				],
				[
					'id' 	=> 'special_collaboration',
					'name' 	=> __('Colaboración especial', 'nar-trans-data'),
					'type' 	=> 'text',
				],
				[
					'id' 	=> 'launch_date',
					'name' 	=> __('Fecha de lanzamiento', 'nar-trans-data'),
					'type' 	=> 'date',
				],
				[
					'id' 	=> 'media_platform',
					'name' 	=> __('Plataforma de medios', 'nar-trans-data'),
					'type' 	=> 'text',
				],
				[
					'id' 	=> 'awards',
					'name' 	=> __('Premios', 'nar-trans-data'),
					'type' 	=> 'text',
				],
				[
					'id' 	=> 'links',
					'name' 	=> __('Enlace(s)', 'nar-trans-data'),
					'type' 	=> 'wysiwyg',
					'options' => array(
						'textarea_rows' => 4,
						'teeny'         => true,
					),
				],
				[
					'id' 	=> 'facebook',
					'name' 	=> __('Facebook', 'nar-trans-data'),
					'type' 	=> 'url',
				],
				[
					'id' 	=> 'twitter',
					'name' 	=> __('Twitter', 'nar-trans-data'),
					'type' 	=> 'url',
				],
				[
					'id' 	=> 'gplus',
					'name' 	=> __('Google Plus', 'nar-trans-data'),
					'type' 	=> 'url',
				],
			),
		);

		return $meta_boxes;

	}

	/**
	 * Devuelve el nombre del CPT
	 */
	function get_post_type() {
		return self::POST_TYPE;
	}

	/**
	 * Query para mostrar asignaturas
	 */
	function get_query($args = [])
	{
		$defaults = [
			'post_type' => self::POST_TYPE,
			'meta_query' => [],
			'orderby' => 'title',
			'order' => 'DESC',
		];

		return new \WP_Query(wp_parse_args((array) $args, $defaults));
	}


	/**
	 * Devuelve una intancia de la clase, si no existe aún, la crea
	 */
	static function get_instance() {
		if (!self::$instance instanceof self)

			self::$instance = new self();

		return self::$instance;
	}
}

if (!function_exists('NarTrans_Resource')) {
	/**
	 * Función para llamar a la instancia de la clase.
	 */
	function NarTrans_Resource() {

		return NarTrans_Resource::get_instance();

	}
}

// Iniciar la clase
NarTrans_Resource();
 ?>
