<?php
defined('ABSPATH') or die();

class NarTrans_Researcher {

	const POST_TYPE = 'researcher';

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
		$singular_name = __('Investigador', 'nar-trans-data');
		$general_name  = __('Investigadores', 'nar-trans-data');

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
				//'thumbnail',
			),
			'public' => true,
			'public_queryable' => false,
			'query_var' => false,
			'rewrite' => ['slug', 'investigador'],
			'has_archive' => 'investigador',
			'hierarchical' => false,
			'exclude_from_search' => false,
			'capability_type' => 'post',
			'menu_icon' => 'dashicons-id',
			'show_in_rest' => false,
		);

		register_post_type(self::POST_TYPE, $args);

	} // Fín registro post type


	/**
	 * Registra las taxonomías
	 */
	function register_taxonomies() {

	} // Fín taxonomias


	/**
	 * Registrar los campos personalizados
	 */
	function register_metaboxes($meta_boxes) {

		$meta_boxes[] = array(
			'id' 			=> self::POST_TYPE . '_custom_fields',
			'title' 		=> __('Datos personalizados investigadores', 'nar-trans-data'),
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
					'id' 	=> 'email',
					'name' 	=> __('Email', 'nar-trans-data'),
					'type' 	=> 'email',
				],
				[
					'id' 	=> 'phone_number',
					'name' 	=> __('Número de teléfono', 'nar-trans-data'),
					'type' 	=> 'text',
				],
				[
					'id' 	=> 'biography',
					'name' 	=> __('Biografía', 'nar-trans-data'),
					'type' 	=> 'wysiwyg',
					'options' => array(
						'textarea_rows' => 4,
						'teeny'         => true,
					),
				],
				[
					'id' 	=> 'webpage',
					'name' 	=> __('Web Page', 'nar-trans-data'),
					'type' 	=> 'url',
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
				[
					'id' 	=> 'linkedin',
					'name' 	=> __('LinkedIn', 'nar-trans-data'),
					'type' 	=> 'url',
				],
				[
					'id' 	=> 'researchgate',
					'name' 	=> __('ResearchGate', 'nar-trans-data'),
					'type' 	=> 'url',
				],
			),
		);

		return $meta_boxes;

	} // Fín Metabox


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

if (!function_exists('NarTrans_Researcher')) {
	/**
	 * Función para llamar a la instancia de la clase.
	 */
	function NarTrans_Researcher() {
		return NarTrans_Researcher::get_instance();
	}
}

// Iniciar la clase
NarTrans_Researcher();

?>
