<?php
/**
 * Plugin Name: Make Custom Section Plugin Example
 * Plugin URI:  https://github.com/thethemefoundry/make-custom-section-plugin
 * Description: Example plugin showcasing Make's custom section API usage.
 * Author:      The Theme Foundry
 * Version:     0.0.2
 * Author URI:  https://thethemefoundry.com
 */

// If we're in an admin page,
// load our custom section definition.
function make_video_player_hook() {
	if ( is_admin() ) {
		add_action( 'after_setup_theme', 'make_video_player_init' );
	}
}

// Add our custom section definition to Make.
function make_video_player_init() {
	$plugin_url = plugin_dir_url( __FILE__ );
	$plugin_path = plugin_dir_path( __FILE__ );

	// Add a list of settings to be configured through the configuration overlay.
	add_filter( 'make_sections_settings', 'make_video_player_settings' );
	// Use this filter to configure a hash of default
	// attributes to be used when instantiating this section in the Builder.
	add_filter( 'make_sections_defaults', 'make_video_player_defaults' );
	// Output Javascript templates for this section in the page footer.
	add_action( 'admin_footer', 'make_video_player_print_templates' );
	// Enqueue Javascript logic for this section.
	add_action( 'admin_enqueue_scripts', 'make_video_player_scripts' );
	// Filter the location for the frontend template.
	add_filter( 'make_load_section_template', 'make_video_player_template', 10, 2 );

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
		'video-player-template',
		// priority of this section
		1000,
		// where to look for templates
		$plugin_path
	);
}

// Enqueue Javascript logic for this section.
function make_video_player_scripts( $deps ) {
	$plugin_url = plugin_dir_url( __FILE__ );

	$dependencies = apply_filters( 'make_builder_js_extensions', array(
		'ttfmake-builder', 'ttfmake-builder-overlay'
	) );

	wp_enqueue_script(
		'make-video-player',
		$plugin_url . 'assets/js/video-player-builder.js',
		$dependencies, false, true
	);
}

// The save routine for this function.
// This is where sanitization should happen.
function make_video_player_save( $input ) {
	$clean_data = $input;

	// Sanitize input data here.

	return $clean_data;
}

// The function gets passed an array of defaults
// for each section currently defined. We append
// our new function defaults here.
function make_video_player_defaults( $defaults ) {
	$defaults['video-player'] = array(
		'section-type' => 'video-player',
		'state' => 'open',
		'video-url' => ''
	);

	return $defaults;
}

// Add one or more settings to this section's overlay,
// with format priority => array(...).
function make_video_player_settings( $settings ) {
	$settings['video-player'] = array(
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

	return $settings;
}

// Output Javascript templates for this section in the footer.
function make_video_player_print_templates() {
	global $hook_suffix, $typenow, $ttfmake_section_data;

	// Only show when adding/editing pages
	if ( ! ttfmake_post_type_supports_builder( $typenow ) || ! in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) )) {
		return;
	}

	$plugin_path = plugin_dir_path( __FILE__ );
	$section_definitions = ttfmake_get_sections();
	$ttfmake_section_data = $section_definitions['video-player'];
	?>
	<script type="text/template" id="tmpl-ttfmake-section-video-player">
	<?php include_once( $plugin_path . 'builder-template.php' ); ?>
	</script>
	<?php
}

function make_video_player_template( $template_file, $slug ) {
	$plugin_path = plugin_dir_path( __FILE__ );

	if ( 'video-player-template' === $slug ) {
		return "$plugin_path$slug.php";
	}

	return $template_file;
}

// Big bang
add_action( 'plugins_loaded', 'make_video_player_hook' );
