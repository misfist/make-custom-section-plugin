<?php
global $ttfmake_section_data;
$video_url = $ttfmake_section_data['video-url'];
?>

<section id="<?php echo esc_attr( ttfmake_get_builder_save()->section_html_id( $ttfmake_section_data ) ); ?>" class="builder-section builder-section-text">
	<div class="builder-section-content">
		<div>
			<?php if ( $video_url !== '' ): ?>
			<iframe src="<?php echo $video_url; ?>" frameborder="0" allowfullscreen></iframe>
			<?php endif; ?>
		</div>
	</div>
</section>