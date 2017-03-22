<?php
/**
 * Plugin Name: Make Custom Section Plugin Example
 * Plugin URI:  https://github.com/thethemefoundry/make-custom-section-plugin
 * Description: Example plugin showcasing Make's custom section API usage.
 * Author:      The Theme Foundry
 * Version:     0.0.1
 * Author URI:  https://thethemefoundry.com
 */

// If we're in an admin page,
// load our custom section definition.
function make_video_player_hook() {
	if ( is_admin() ) {
		add_action( 'after_setup_theme', 'make_video_player_init' );
	}
}

// Add our custom section definition
// to Make.
function make_video_player_init() {
	$plugin_url = plugin_dir_url( __FILE__ );
	$plugin_path = plugin_dir_path( __FILE__ );

	ttfmake_add_section(
		// a unique id for this section
		'video-player',
		// a label for this section
		__( 'VideoPlayer', 'make' ),
		// a section icon to be used in the menu
		$plugin_url . '/assets/images/video_player.png',
		// the title for this section's menu button link
		__( 'Create a sample video player.', 'make' ),
		// save callback
		'make_video_player_save',
		// name of the builder template, without extension
		'builder-template',
		// name of the frontend template, without extension
		'frontend-template',
		// priority of this section
		1000,
		// where to look for templates
		$plugin_path,
		// a callback returning zero or more settings
		// to be displayed in this section's overlay
		make_video_player_get_settings()
	);

	// Use this filter to configure a hash of default
	// attributes to be applied when instantiating new Backbone models
	// for this section in the Builder.
	add_filter( 'make_section_defaults', 'make_video_player_defaults' );
	// Use this filter to append one or more scripts to the Builder.
	add_filter( 'make_builder_js_dependencies', 'make_video_player_js_dependencies' );
}

// Add a Backbone model and view for this section.
// Backbone views is where all the Builder logic happens.
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

// The function gets called with this section's
// unfiltered input data. It should return this
// section's sanitized data.
function make_video_player_save( $input ) {
	$clean_data = array();

	// video-url is our example field
	if ( isset( $input['video-url'] ) ) {
		// Sanitization and validation should happen here.
		$clean_data['video-url'] = $input['video-url'];
	}

	return $clean_data;
}

// The function gets called with this section's
// defaults. Add new defaults, and they'll be used
// to populate the Backbone model for this section.
function make_video_player_defaults( $defaults ) {
	$defaults['video-player'] = array(
		'state' => 'open',
		'video-url' => ''
	);

	return $defaults;
}

// Add one or more settings to this section's overlay,
// with format priority => array(...).
function make_video_player_get_settings() {
	return array(
		100 => array(
			// Type of the field
			'type'  => 'text',
			// Name of the field
			'name'  => 'video-url',
			// Label for this field
			'label' => __( 'Enter a video URL', 'make' ),
			// Default value for this field.
			// Use ttfmake_get_section_default to be sure
			// your defaults stay consistent.
			'default' => ttfmake_get_section_default( 'video-url', 'video-player' ),
		)
	);
}

// Big bang
add_action( 'plugins_loaded', 'make_video_player_hook' );
