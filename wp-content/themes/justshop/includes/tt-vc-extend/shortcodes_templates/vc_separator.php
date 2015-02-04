<?php
$output = '';
extract(shortcode_atts(array(
    'tt_line' => 'yes'
), $atts));

if( $tt_line == "yes" ) $tt_line = "tt_noline";
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_separator wpb_content_element', $this->settings['base']);
$output .= '<div class="'.$tt_line.' templatation '.$css_class.'"></div>'.$this->endBlockComment('separator')."\n";

echo $output;