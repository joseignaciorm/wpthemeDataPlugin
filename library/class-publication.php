<?php
defined('ABSPATH') or die();
class NarTrans_Publication {

	const POST_TYPE = 'publication';

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
		$singular_name = __('Publicación', 'nar-trans-data');
		$general_name  = __('Publicaciones', 'nar-trans-data');

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
				'all_items'          => sprintf(__('Todas las %s', 'nar-trans-data'), $general_name),
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
			'taxonomies' => array('post_tag'),
			'public' => true,
			'public_queryable' => false,
			'query_var' => false,
			'rewrite' => [ 'slug' => 'investigacion' ],
			'has_archive' => 'investigacion',
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

		$singular_name = __('Tipo de publicación', 'nar-trans-data');
		$plural_name   = __('Tipos de publicaciones', 'nar-trans-data');

		register_taxonomy('publication_type', self::POST_TYPE, array(
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
			'rewrite'			=>	array('slug' => 'tipo-publicacion')
		));

		/*$singular_name = __('Etiqueta', 'nar-trans-data');
		$plural_name   = __('Etiquetas', 'nar-trans-data');

		register_taxonomy('publication_tags', self::POST_TYPE, array(
			'hierarchical'      => false,
			'labels'            => array(
				'name'              => $plural_name,
				'singular_name'     => $singular_name,
				'search_items'      => sprintf(__('Buscar %s', 'nar-trans-data'), $singular_name),
				'all_items'         => sprintf(__('Todas las %s', 'nar-trans-data'), $plural_name),
				'parent_item'       => sprintf(__('%s superior', 'nar-trans-data'), $singular_name),
				'parent_item_colon' => sprintf(__('%s superior:', 'nar-trans-data'), $singular_name),
				'edit_item'         => sprintf(__('Editar %s', 'nar-trans-data'), $singular_name),
				'update_item'       => sprintf(__('Actualizar %s', 'nar-trans-data'), $singular_name),
				'add_new_item'      => sprintf(_x('Nueva %s', 'femenino', 'nar-trans-data'), $singular_name),
				'new_item_name'     => sprintf(_x('Nuevo nombre de %s', 'nar-trans-data'), $singular_name),
				'menu_name'         => $plural_name,
			),
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
		));*/
	} // Fín registro de las taxonomies


	/**
	 * Registrar los campos personalizados
	 */

	function register_metaboxes($meta_boxes) {

		$meta_boxes[] = array(
			'id' => self::POST_TYPE . '_custom_fields',
			'title' => __('Campos personalizados de la publicación', 'nar-trans-data'),
			'post_types' => array(self::POST_TYPE),
			'context' => 'advanced',
			'priority' => 'default',
			'autosave' => false,
			'fields' => array(

				[
					'id' 	=> 'id_old',
					'name'	=> 'ID antiguo',
					'type' 	=> 'text',
				],
				[
					'id' 	=> 'year',
					'name' 	=> __('Año', 'nar-trans-data'),
					'type' 	=> 'number',
				],
				[
					'id' 	=> 'magazine',
					'name' 	=> __('Nombre de la revista', 'nar-trans-data'),
					'type' 	=> 'text',
				],
				[
					'id' 	=> 'doi',
					'name' 	=> __('DOI', 'nar-trans-data'),
					'type' 	=> 'text',
				],
				[
					'id' 			=> 'research_id',
					'name' 			=> __('Investigadores', 'nar-trans-data'),
					'type' 			=> 'post',
					'post_type' 	=> [ NarTrans_Researcher::POST_TYPE ],
					'field_type'	=> 'select_advanced',
					'multiple' 		=> true,
				],
				[
					'id' 	=> 'link',
					'name' 	=> __( 'URL', 'nar-trans-data'),
					'type' 	=> 'url',
				],
				[
					'id' 	=> 'publication_date',
					'name' 	=> __('Fecha de publicación', 'nar-trans-data'),
					'type' 	=> 'date',
				],

			),
		);
		return $meta_boxes;
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

if (!function_exists('NarTrans_Publication')) {
	/**
	 * Función para llamar a la instancia de la clase.
	 */
	function NarTrans_Publication()
	{
		return NarTrans_Publication::get_instance();
	}
}

// Iniciar la clase
NarTrans_Publication();

?>
