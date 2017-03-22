<?php
/*
Plugin Name: Make Custom Sections Example
*/

function make_video_player_hook() {
	if ( is_admin() ) {
		add_action( 'after_setup_theme', 'make_video_player_init' );
	}
}

function make_video_player_init() {
	$plugin_url = plugin_dir_url( __FILE__ );
	$plugin_path = plugin_dir_path( __FILE__ );

	ttfmake_add_section(
		'video-player',
		__( 'VideoPlayer', 'make' ),
		$plugin_url . '/assets/images/video_player.png',
		__( 'Create a sample video player.', 'make' ),
		'make_video_player_save',
		'builder-template',
		'frontend-template',
		1000,
		$plugin_path,
		make_video_player_get_settings()
	);

	add_filter( 'make_section_defaults', 'make_video_player_defaults' );
	// add_filter( 'make_get_section_json', array ( $this, 'get_section_json' ), 10, 1 );
	add_filter( 'make_builder_js_dependencies', 'make_video_player_js_dependencies' );
}

function make_video_player_js_dependencies( $deps ) {
	$plugin_url = plugin_dir_url( __FILE__ );

	wp_register_script(
		'make-video-player',
		$plugin_url . 'assets/js/video-player-builder.js',
		array(
			'ttfmake-builder/js/models/section.js',
			'ttfmake-builder/js/views/section.js'
		)
	);

	return array_merge( $deps, array(
		'make-video-player'
	) );
}

function make_video_player_save( $input ) {
	$clean_data = array();

	if ( isset( $input['video-url'] ) ) {
		$clean_data['video-url'] = $input['video-url'];
	}

	return $clean_data;
}

function make_video_player_defaults( $defaults ) {
	$defaults['video-player'] = array(
		'state' => 'open',
		'video-url' => ''
	);

	return $defaults;
}

function make_video_player_get_settings() {
	return array(
		100 => array(
			'type'  => 'text',
			'name'  => 'video-url',
			'label' => __( 'Enter a video URL', 'make' ),
			'default' => ttfmake_get_section_default( 'video-url', 'video-player' ),
		)
	);
}


add_action( 'plugins_loaded', 'make_video_player_hook' );