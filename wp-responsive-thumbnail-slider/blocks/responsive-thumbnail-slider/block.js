( function ( blocks, element, i18n, blockEditor ) {
	'use strict';

	var el = element.createElement;
	var __ = i18n.__;
	var useBlockProps = blockEditor.useBlockProps;

	// Populated via wp_add_inline_script(); sensible fallbacks if it's ever missing.
	var data = window.rtsBlockPlaceholderData || {
		engine: __( 'Legacy', 'wp-responsive-thumbnail-slider' ),
		visible: 5,
		imageCount: 0,
		auto: __( 'Off', 'wp-responsive-thumbnail-slider' ),
		circular: __( 'Off', 'wp-responsive-thumbnail-slider' ),
		proUrl: 'https://www.i13websolution.com/product/wordpress-responsive-thumbnail-html-slider-pro/',
	};

	function badge( className, text ) {
		return el( 'span', { className: 'rts-badge ' + className }, text );
	}

	blocks.registerBlockType( 'wp-responsive-thumbnail-slider/slider', {
		title: __( 'Responsive Thumbnail Slider', 'wp-responsive-thumbnail-slider' ),
		description: __(
			'Displays your Responsive Thumbnail Slider. Manage images and settings from the Responsive Thumbnail Slider admin menu.',
			'wp-responsive-thumbnail-slider'
		),
		icon: 'images-alt2',
		category: 'widgets',
		keywords: [
			__( 'slider', 'wp-responsive-thumbnail-slider' ),
			__( 'carousel', 'wp-responsive-thumbnail-slider' ),
			__( 'gallery', 'wp-responsive-thumbnail-slider' ),
		],
		supports: {
			html: false,
			multiple: true,
		},

		edit: function () {
			// useBlockProps() is required in API v2 blocks so the editor can attach
			// selection, the toolbar, drag handles, etc. to this element.
			var blockProps = useBlockProps( { className: 'rts-block-placeholder' } );

			return el(
				'div',
				blockProps,
				el( 'span', { className: 'dashicons dashicons-images-alt2 rts-block-icon' } ),
				el( 'div', { className: 'rts-block-title' }, __( 'Responsive Thumbnail Slider', 'wp-responsive-thumbnail-slider' ) ),

				el(
					'div',
					{ className: 'rts-block-badges' },
					badge( 'rts-badge-green', __( 'Auto Slide: ', 'wp-responsive-thumbnail-slider' ) + data.auto )
				),

				el(
					'div',
					{ className: 'rts-block-badges' },
					badge( 'rts-badge-blue', __( 'Engine: ', 'wp-responsive-thumbnail-slider' ) + data.engine ),
					badge( 'rts-badge-blue', __( 'Visible: ', 'wp-responsive-thumbnail-slider' ) + data.visible ),
					badge( 'rts-badge-blue', __( 'Images: ', 'wp-responsive-thumbnail-slider' ) + data.imageCount )
				),

				el(
					'div',
					{ className: 'rts-block-badges' },
					badge( 'rts-badge-green', __( 'Circular Loop: ', 'wp-responsive-thumbnail-slider' ) + data.circular )
				),

				el(
					'p',
					{ className: 'rts-block-desc' },
					__( 'Slider renders on the frontend. Use the Slider Settings page to configure it.', 'wp-responsive-thumbnail-slider' )
				),

				el(
					'p',
					{ className: 'rts-block-upsell' },
					el(
						'a',
						{ href: data.proUrl, target: '_blank', rel: 'noopener noreferrer' },
						__( 'Want unlimited sliders, bulk image upload, and more animations? ', 'wp-responsive-thumbnail-slider' ),
						el( 'strong', {}, __( 'See Pro →', 'wp-responsive-thumbnail-slider' ) )
					)
				)
			);
		},

		save: function () {
			// Server-rendered block; front-end output comes from the render_callback in PHP.
			return null;
		},
	} );
} )( window.wp.blocks, window.wp.element, window.wp.i18n, window.wp.blockEditor );
