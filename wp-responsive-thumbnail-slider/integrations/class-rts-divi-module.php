<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'RTS_Divi_Module' ) ) {

	class RTS_Divi_Module extends ET_Builder_Module {

		public $slug       = 'rts_responsive_thumbnail_slider';
		public $vb_support = 'off';

		public function init() {
			$this->name             = esc_html__( 'Responsive Thumbnail Slider', 'wp-responsive-thumbnail-slider' );
			$this->main_css_element = '%%order_class%%';
		}

		public function get_settings_modal_toggles() {
			return array(
				'general' => array(
					'toggles' => array(
						'main_content' => esc_html__( 'Slider', 'wp-responsive-thumbnail-slider' ),
					),
				),
			);
		}

		public function get_fields() {
			return array();
		}

		public function render( $attrs, $content, $render_slug ) {

			if ( function_exists( 'et_fb_is_enabled' ) && et_fb_is_enabled() && function_exists( 'rts_render_editor_placeholder_card' ) ) {
				return rts_render_editor_placeholder_card();
			}

			// Divi can render module content after the normal wp_enqueue_scripts
			// timing, which sometimes prevents styles from making it into the
			// page <head>. Enqueue the specificity fix explicitly here as well;
			// the plugin's wp_footer fallback will reprint it if still missing.
			wp_enqueue_style( 'rts-divi-fix' );

			if ( function_exists( 'print_responsive_thumbnail_slider_func' ) ) {
				return print_responsive_thumbnail_slider_func();
			}

			return '';
		}
	}
}
