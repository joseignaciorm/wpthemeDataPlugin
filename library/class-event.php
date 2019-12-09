<?php
defined('ABSPATH') or die();

class NarTrans_Event {

	const POST_TYPE = 'event';

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
		$singular_name 	= __('Evento', 'nar-trans-data');
		$general_name 	= __('Eventos', 'nar-trans-data');

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
				//'custom-fields',
				//'author',
				'thumbnail',
			),
			'public' => true,
			'public_queryable' => false,
			'query_var' => false,
			'rewrite' => [ 'slug' => 'evento' ],
			'has_archive' => 'eventos',
			'hierarchical' => false,
			'exclude_from_search' => false,
			'capability_type' => 'post',
			'menu_icon' => 'dashicons-id',
			'show_in_rest' => false,
		);

		register_post_type(self::POST_TYPE, $args);
	} // Fín de registro CPT

	/**
	 * Registra las taxonomías
	 */
	function register_taxonomies() {
		$singular_name = __('Tipo de event', 'nar-trans-data');
		$plural_name   = __('Tipos de eventos', 'nar-trans-data');

		register_taxonomy('event_type', self::POST_TYPE, array(
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
			'rewrite' => [ 'slug' => 'tipo-de-evento' ],
		));
	} // Fín taxonomies


	/**
	 * Registrar los campos personalizados
	 */
	function register_metaboxes($meta_boxes) {

		$meta_boxes[] = array(
			'id' 			=> self::POST_TYPE . '_custom_fields',
			'title' 		=> __('Datos personalizados del evento', 'nar-trans-data'),
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
					'id' 	=> 'date_start',
					'name' 	=> __('Fecha inicio', 'nar-trans-data'),
					'type' 	=> 'date',
				],
				[
					'id' 	=> 'date_end',
					'name' 	=> __('Fecha fín', 'nar-trans-data'),
					'type' 	=> 'date',
				],

			)
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
	 * Devuelve una intancia de la clase, si no existe aún, la crea
	 */
	static function get_instance() {
		if (!self::$instance instanceof self)
			self::$instance = new self();

		return self::$instance;
	}

	/**
	 * Query para mostrar asignaturas
	 */
	function get_query($args = []) {
		$defaults = [
			'post_type' => self::POST_TYPE,
			'meta_query' => [],
			'orderby' => 'title',
			'order' => 'ASC',
		];

		return new \WP_Query(wp_parse_args((array) $args, $defaults));
	}

} // Fín de la clase

	if (!function_exists('NarTrans_Event')) {
	/**
	 * Función para llamar a la instancia de la clase.
	 */
	function NarTrans_Event() {
		return NarTrans_Event::get_instance();
	}
}

// Iniciar la clase
NarTrans_Event();

?>
