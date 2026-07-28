<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'RTS_Elementor_Widget' ) ) {

	class RTS_Elementor_Widget extends \Elementor\Widget_Base {

		public function get_name() {
			return 'rts-responsive-thumbnail-slider';
		}

		public function get_title() {
			return __( 'Responsive Thumbnail Slider', 'wp-responsive-thumbnail-slider' );
		}

		public function get_icon() {
			return 'eicon-post-slider';
		}

		public function get_categories() {
			return array( 'general' );
		}

		public function get_keywords() {
			return array( 'slider', 'carousel', 'thumbnail', 'gallery', 'responsive' );
		}

		protected function register_controls() {

			$this->start_controls_section(
				'rts_notice_section',
				array(
					'label' => __( 'Responsive Thumbnail Slider', 'wp-responsive-thumbnail-slider' ),
				)
			);

			$settings_url = admin_url( 'admin.php?page=responsive_thumbnail_slider' );

			$this->add_control(
				'rts_settings_notice',
				array(
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'raw'  => sprintf(
						'<p>%1$s</p><p><a href="%2$s" target="_blank" rel="noopener noreferrer">%3$s</a></p>',
						esc_html__( 'Manage images and slider behavior (visible count, autoplay, engine, etc.) from the Responsive Thumbnail Slider admin menu.', 'wp-responsive-thumbnail-slider' ),
						esc_url( $settings_url ),
						esc_html__( 'Open Slider Settings →', 'wp-responsive-thumbnail-slider' )
					),
					'content_classes' => 'rts-elementor-notice',
				)
			);

			$this->end_controls_section();
		}

		protected function render() {

			$in_editor = class_exists( '\Elementor\Plugin' )
				&& isset( \Elementor\Plugin::$instance->editor )
				&& \Elementor\Plugin::$instance->editor->is_edit_mode();

			if ( $in_editor && function_exists( 'rts_render_editor_placeholder_card' ) ) {
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- pre-built, already-escaped card markup.
				echo rts_render_editor_placeholder_card();
				return;
			}

			if ( function_exists( 'print_responsive_thumbnail_slider_func' ) ) {
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- returns pre-built, already-escaped slider markup.
				echo print_responsive_thumbnail_slider_func();
			}
		}
	}
}
