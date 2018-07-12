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
		add_action( 'init', array( $this, 'register_post_type' ) );
	}

	public function register_post_type()
	{
		register_post_type( 'shops', array(
			'label'                => "店舗",
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
			'rest_base'             => 'shops',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		) );

		register_taxonomy( 'shop-category', array( 'shops' ), array(
			'hierarchical'      => false,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_admin_column' => false,
			'query_var'         => true,
			'rewrite'           => array(
				'with_front' => false,
			),
			'capabilities'      => array(
				'manage_terms'  => 'edit_posts',
				'edit_terms'    => 'edit_posts',
				'delete_terms'  => 'edit_posts',
				'assign_terms'  => 'edit_posts',
			),
			'label'             => "カテゴリー",
			'show_in_rest'      => true,
			'rest_base'         => 'shop-category',
			'rest_controller_class' => 'WP_REST_Terms_Controller',
		) );

		$text_field = new Shop_Meta( 'shop-meta', '店舗情報' );
		$text_field->add( 'shops' );

		$map = new Map( 'latlng', '位置情報' );
		$map->add( 'shops' );

		add_image_size( '_shops', 480, 270, true );
	}
}