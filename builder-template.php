<?php
// Load common partials for this section. Namely, the settings overlay.
ttfmake_load_section_header();
?>

<?php
// Use this global to access this section's data.
global $ttfmake_section_data;
?>

<p class="make-video-player-notice" style="display: none;">Configure a video URL first.</p>

<iframe src="" frameborder="0" allowfullscreen style="display: none;"></iframe>

<?php
// Load common partials for this section.
ttfmake_load_section_footer();