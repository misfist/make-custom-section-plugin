<?php $video_url = ttfmake_get_section_field('video-url'); ?>

<section id="<?php echo ttfmake_get_section_html_id(); ?>" class="builder-section builder-section-text">
	<div class="builder-section-content">
		<div>
			<?php if ( $video_url !== '' ): ?>
			<iframe src="<?php echo $video_url; ?>" frameborder="0" allowfullscreen></iframe>
			<?php endif; ?>
		</div>
	</div>
</section>