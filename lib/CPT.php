<?php

namespace _Shops;
use \Miya\WP\Custom_Field\Map;

class CPT
{
	public static function get_instance()
	{
		static $instance;
		if ( ! $instance ) {
			$instance = new CPT();
		}
		return $instance;
	}

	public function __construct()
	{
		add_action( 'init', array( $this, 'register_post_type' ), 11 );
	}

	public function register_post_type()
	{
		$cpt = apply_filters( 'shop_post_type', 'shops' );
		$cpt_label = apply_filters( 'shop_cpt_label', 'Shop' );
		$tax = apply_filters( 'shop_tax', 'menu' );
		$tax_label = apply_filters( 'shop_tax_label', 'Category' );

		register_post_type( $cpt, array(
			'label'                 => $cpt_label,
			'public'                => true,
			'hierarchical'          => false,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'has_archive'           => false,
			'rewrite'               => array(
				'with_front' => false,
			),
			'query_var'             => true,
			'menu_icon'             => 'dashicons-store',
			'show_in_rest'          => true,
			'rest_base'             => $cpt,
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		) );

		register_taxonomy( $tax, array( $cpt ), array(
			'hierarchical'      => true,
			'public'            => false,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => false,
			'capabilities'      => array(
				'manage_terms'  => 'edit_posts',
				'edit_terms'    => 'edit_posts',
				'delete_terms'  => 'edit_posts',
				'assign_terms'  => 'edit_posts',
			),
			'label'             => $tax_label,
			'show_in_rest'      => true,
			'rest_base'         => $tax,
			'rest_controller_class' => 'WP_REST_Terms_Controller',
		) );

		$text_field = new Shop_Meta( 'shop-meta', '店舗情報' );
		$text_field->add( $cpt );

		$map = new Map( '_latlng', '位置情報' );
		$map->add( $cpt );

		add_image_size( $cpt . '_images', 480, 270, true );
	}
}
