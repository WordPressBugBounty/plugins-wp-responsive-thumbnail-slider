=== Responsive Thumbnail Slider ===
Contributors: nik00726
Donate link: https://www.i13websolution.com/product/wordpress-responsive-thumbnail-html-slider-pro/
Tags: responsive slider, thumbnail slider, thumbnail carousel, image slider, gutenberg block
Requires at least: 3.5
Tested up to: 7.0
Version: 1.1.53
Stable tag: 1.1.53
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A fast, lightweight responsive thumbnail slider for WordPress — modern animation engine, lightbox, captions, and full theme/builder compatibility. Free forever.

== Description ==

**Responsive Thumbnail Slider** lets you build a clean, responsive image slider and drop it anywhere on your site — no coding required. It's built to be lightweight and fast by default, with a modern rendering engine that doesn't even require jQuery on the front end.

**[Live Demo](http://blog.i13websolution.com/live-preview-responsive-thumbnail-slider-pro/)**

= Two rendering engines =

* **Modern** — a lightweight, dependency-free engine (no jQuery required for the slider itself), touch/swipe-friendly, with lazy-loaded images
* **Legacy** — the original engine, kept for sites that want it exactly as-is
* Existing sites automatically stay on Legacy after updating, so nothing changes on your live site — new installs default to Modern


**WordPress Responsive Thumbnail carousel slider Video**

[youtube https://www.youtube.com/watch?v=SVmoz3p7egs]


= Everything you need for a great-looking slider =

* Add any number of images to your slider
* Set image height and width, slider speed, and how many images are visible at once
* Circular (looping) slider, or arrow-only navigation
* Auto-slide, or manual control with left/right arrows
* Optional pager dots and image captions
* Optional **lightbox** — clicking a slide opens the full image in a clean overlay
* Preview your slider before publishing it
* Image name doubles as the alt tag for SEO
* Responsive admin layout and WordPress capability support
* No advertisements

= Simple to add anywhere =

Use the shortcode `[print_responsive_thumbnail_slider]` in any page, post, or widget — or use it directly in a theme template with `do_shortcode()`. Full Gutenberg block editor support is built in.

= Need more than one slider? =

The free version gives you **one** slider — great for a single homepage banner or gallery. If you need more, **[Responsive Thumbnail Slider PRO](https://www.i13websolution.com/product/wordpress-responsive-thumbnail-html-slider-pro/)** unlocks:

* **Unlimited sliders** — a completely different, independent slider for every page
* **16 real easing animation curves**, including true Bounce and Elastic motion
* **Bulk image upload**, drag-to-reorder, or random image order
* **Per-slider styling** — border color, radius, box-shadow, crop / no-crop modes
* **Per-image custom links, link targets, and captions**
* **Native Elementor widget and Divi module**, both with live builder previews
* **Full Gutenberg block editor control** — create and edit sliders, and pick images from the Media Library, without leaving the block sidebar
* **Per-slider analytics dashboard** — impressions, clicks, and click-through rate, with a 30-day graph (aggregate-only, no visitor tracking)

**[See Responsive Thumbnail Slider PRO →](https://www.i13websolution.com/product/wordpress-responsive-thumbnail-html-slider-pro/)**

[Get Support](https://www.i13websolution.com/contacts)

== Installation ==

1. Upload the plugin folder to `wp-content/plugins/`, or install it directly from the WordPress plugin directory.
2. Activate the plugin from the Plugins screen in your WordPress admin.
3. Go to **Responsive Thumbnail Slider** in the admin menu to configure your slider and add images.

= Usage =

1. Manage your images from the **Manage Images** menu.
2. Configure slider behavior from the **Slider Settings** menu.
3. Preview your slider anytime from the **Preview Slider** menu before publishing it.
4. Add it to a page or post with the shortcode:

`[print_responsive_thumbnail_slider]`

Or in a theme template:

`<?php echo do_shortcode('[print_responsive_thumbnail_slider]'); ?>`

Need more than one slider on your site? **[Upgrade to PRO](https://www.i13websolution.com/product/wordpress-responsive-thumbnail-html-slider-pro/)** for unlimited independent sliders.

== Screenshots ==


1. Slider Setting
2. Manage Images 
3. Preview Slider
4. Front End slider
5. Pro version manage sliders
6. Pro version add/edit image
7. Pro version Manage images.
8. Pro version edit slider.
9. Pro version crop and non crop Front End slider. 
10. Block Editor support

== License ==


This plugin is free for everyone! Since it's released under the GPL, you can use it free of charge on your personal or commercial blog. But you can make some donations if you realy find it useful.


== Changelog ==


= 1.1.54 =

* Fixed: square/disc bullet markers could show next to slides on some themes, on both engines. The Modern engine's list-style reset had no !important, so a theme with equally-specific or more aggressive list styling could override it (a fix we'd already applied to the Divi-specific stylesheet but never to the base CSS). The Legacy engine's stylesheet was missing a list-style reset entirely, relying only on bxSlider's own JS to suppress bullets, which can fail against certain themes.


= 1.1.48 =

* Fixed: Lightbox showed a caption even when "Show caption" was turned off. The lightbox caption now only appears when Show caption is enabled, matching the slider itself.


= 1.1.47 =

* Fixed: Lightbox didn't work on the admin Preview page — its assets were only registered on the front end, so enqueuing them on the admin page silently did nothing (same class of bug fixed earlier for the modern engine's editor CSS). Now also registered for admin context.


= 1.1.46 =

* Added 50px top padding to the Pro upgrade box's sidebar on the Settings, Manage Images, and Add Image pages


= 1.1.45 =

* Reverted the previous change — Pro upgrade box moved back to the original ad location (bottom sidebar), since placing it beside the Stats box created an awkward gap before the settings form. Stats box now stands alone at the top again.


= 1.1.44 =

* Moved the Pro upgrade box on the Settings page to sit directly beside the Slider Stats box (flex row at the top of the page), instead of appearing separately at the bottom of the page in the sidebar — removed the now-duplicate copy from the bottom sidebar


= 1.1.43 =

* Removed remaining third-party affiliate ad banners (Elegant Themes/Divi, Google Workspace coupon) from the Settings, Manage Images, and Add Image admin sidebars
* Replaced them with a proper Pro upsell box in the same native sidebar location, and consolidated the earlier top-of-page Pro box into this one spot per page to avoid showing it twice


= 1.1.42 =

* Removed the old Facebook "Like" banner, PayPal donate banner, and plain-text "Upgrade to Pro" links from the Settings, Manage Images, and Add Image admin pages
* Added a proper Pro upsell sidebar box (Settings and Manage Images pages), listing the key Pro features with a clear call-to-action button


= 1.1.41 =

* New: Lightbox toggle (Slider Settings > Lightbox) — clicking a slide opens the full image in an overlay instead of following "Add link to image". Works on both Modern and Legacy engines, and the admin Preview page.
* New: Slider Stats box on the Settings page — aggregate-only impressions/clicks/click-through-rate, all-time and last 7 days. No visitor tracking, no cookies, no identifying data — just daily totals, tracked via IntersectionObserver (impressions) and sendBeacon (clicks).


= 1.1.40 =

* Fixed: with a Scroll amount greater than 1, the "previous" arrow could jump straight past all valid content in a single move and try to render a DOM position with no clone at all — a bigger problem than a late boundary trigger, since there's zero cushion below the very first cloned slide. Index is now clamped to the actual clone-buffer extent before ever rendering, regardless of scroll step size, so it's impossible to attempt showing a position that doesn't exist.


= 1.1.39 =

* Fixed: left/"previous" arrow specifically still misbehaved after the last fix — the backward loop-boundary triggered one step too late (index < lower instead of index <= lower), so it briefly tried to animate toward a DOM position where no cloned slide exists at all (not just late — genuinely invalid), unlike the forward direction, whose boundary happens to trigger exactly at the edge of valid content. Backward now triggers at the same point, mirroring forward exactly.


= 1.1.38 =

* Fixed: an arrow click right after the slider completed a loop (wrapped from last slide back to first, or vice versa) could jump instantly instead of animating. The loop-reset itself is an intentional instant jump (to make the loop seamless) — but if the very next animated move happened too soon afterward, the browser could coalesce both style writes together and never actually paint the "before" state, so the transition had nothing visible to animate from. Now forces a reflow before every animated move, guaranteeing the prior state is painted first.


= 1.1.37 =

* Fixed: the "previous" arrow specifically (not "next") could get stuck/stop responding, particularly with more images than visible slots. The backward loop-boundary was calculated as cloneCount-realCount, which goes deeply negative whenever you have more real images than visible slides — letting backward navigation travel into DOM positions where no cloned slide actually exists. The boundary is now a fixed 0, matching where the actual clone buffer starts.


= 1.1.36 =

* Fixed: clicking a pager dot could sometimes update the dot's active state but leave the slider itself in place — pager clicks didn't cancel a still-pending loop-reset from a recent arrow/autoplay move, so that stale reset could fire moments later and silently snap the slider back, overriding the pager's navigation. Pager clicks now cancel any pending reset immediately.


= 1.1.35 =

* Fixed: Modern engine's left/right arrows (and autoplay) could permanently stop responding after a window resize/reflow happened to coincide with the slider crossing its loop boundary — the loop-reset relied solely on the browser's transitionend event, and a single missed event left navigation silently blocked forever. Added a timeout fallback so the reset always completes even if that event is missed.


= 1.1.34 =

* New: friendly, dismissible review request — shown to new installs after 7 days of use, and as a one-time "thanks for updating" prompt to existing sites after upgrading to a new version
* Shown only to admins (manage_options), only on the Plugins page and this plugin's own admin pages, with "Remind me later" (snoozes 14 days) and "No thanks" (permanent opt-out) options
* Dismissals persist immediately via AJAX rather than just hiding client-side


= 1.1.33 =

* Fixed: Legacy engine arrows, pager dots, and captions weren't showing properly under Divi — the previous Divi fix only reinforced borders/margins on these elements, not the actual positioning and background-image sprite that make them visible in the first place. Arrows are image sprites with hidden text, so a stripped background-image makes them invisible rather than obviously broken. Reinforced full positioning, sizing, and the sprite background for arrows/pager, and position/background/text styling for captions.


= 1.1.32 =

* Fixed: Legacy engine rendered as a plain stacked list under Divi instead of a horizontal carousel, with no console errors — bxSlider sets its horizontal layout (float:left on each slide) via plain inline style at init, and Divi's own !important list/float resets were overriding that after the fact. Reinforced float/list-style/overflow/position on the wrapper, viewport, and slide items to match bxSlider's own specificity, without touching the JS-controlled margin, width, or position values (which differ per Fade vs horizontal mode and per your settings)


= 1.1.31 =

* Fixed: Divi fix stylesheet was missing a rule for the Modern engine's caption — added, in case Divi's own span/text styling was overriding its position/background and making it invisible under Divi


= 1.1.30 =

* New: Divi CSS specificity fix (css/rts-divi-fix.css), same pattern used in our other Divi integrations — reinforces the slider's list/image/arrow/pager/caption styling against Divi's own high-specificity theme CSS
* Auto-loads whenever Divi (theme or Builder plugin) is detected; enqueued both proactively on page load and explicitly inside the Divi module's render(), with the wp_footer fallback as a final safety net
* No effect on sites without Divi


= 1.1.29 =

* Fixed: Divi module still broke the Visual Builder settings panel — switched vb_support to 'off' (matching our other Divi modules) and added the required get_settings_modal_toggles() definition, which the VB's settings panel expects even for modules with no configurable fields
* Added a wp_footer fallback that reprints any of the plugin's styles/scripts that page builders enqueued too late for wp_head, matching the safety-net pattern used in our other plugins' Divi integrations


= 1.1.28 =

* Fixed: Divi module broke the Visual Builder's settings panel (showing a fragment of Divi's own JS bundle instead of the module content) — caused by an unsupported 'warning' field type on the module's only custom field; removed it since the module needs no configurable fields (settings live on the plugin's Slider Settings page, same as the Elementor widget)


= 1.1.27 =

* Fixed: placeholder card in Elementor/Divi showed as unstyled plain text — the CSS was being enqueued inside the widget's render() call, which is too late since both builders add widgets to the canvas via an AJAX call that returns an HTML fragment with no <head>. The card CSS is now enqueued early (during the normal page-load pass that builds the preview), before any widget gets added.
* Fixed: placeholder icon wasn't showing — dashicons (the icon font) isn't loaded on front-end pages by default, and Elementor/Divi's canvas is technically a front-end page; now enqueued alongside the card CSS


= 1.1.26 =

* Changed: Elementor and Divi builder canvases now show the same settings-summary placeholder card as the Gutenberg block editor (icon, engine/visible/image-count badges, autoplay/circular status, Pro upsell) instead of the live slider while editing
* Live slider still renders normally in Elementor's Preview mode, Divi's non-Visual-Builder view, and on the actual frontend
* Refactored the placeholder data/markup into shared functions reused by all three integrations


= 1.1.25 =

* Fixed: block could be inserted but not selected, moved, or removed — the editor preview wasn't wrapped with useBlockProps(), which API v2 blocks require for the editor to recognize the element as the block itself


= 1.1.24 =

* New: Elementor widget ("Responsive Thumbnail Slider") — drag it into any Elementor layout; renders using your current slider settings and engine
* New: Divi module ("Responsive Thumbnail Slider") — available in the Divi Builder module list; renders the same way
* Both integrations only load when the respective page builder is active — no effect on sites without Elementor/Divi installed


= 1.1.23 =

* Changed: Gutenberg block editor preview now shows a settings-summary placeholder card (engine, visible count, auto slide, circular loop, image count) instead of a live server-rendered preview — matches the block style used across our other plugins and avoids editor-context styling quirks
* Placeholder reflects whichever engine (Modern or Legacy) is currently active


= 1.1.22 =

* New: Gutenberg block ("Responsive Thumbnail Slider") — insert the slider from the block inserter instead of using the shortcode manually, with a live preview right in the editor
* Block preview automatically loads whichever engine (Modern or Legacy) is currently selected in Slider Settings


= 1.1.21 =

* Fixed: Modern engine's "Visible" setting wasn't constraining the widget's own width, so a wider parent column could reveal a partial extra slide (e.g. "3 visible" showing ~4.5 images) — the widget now sizes itself to exactly that many slides, matching the Legacy engine


= 1.1.20 =

* Fixed: Modern engine's caption bar squared off the bottom of the rounded thumbnail corners since it had no rounding of its own — corner rounding now lives on the slide container so the caption (and anything else) is clipped to match


= 1.1.19 =

* Fixed: Modern engine was stretching thumbnails to fill the available container width instead of honoring the configured Image Width/Height setting — it now renders slides at a fixed size like the Legacy engine, and only adjusts how many are visible based on container width


= 1.1.18 =

* Fixed: Slider Engine radio buttons on the settings page rendered oversized (missing the standard sizing style used elsewhere on the page)
* Fixed: Modern engine autoplay loop reset used a guessed timeout instead of waiting for the actual CSS transition to finish, which could cause the transition to restart mid-animation and look stuck/jerky — now uses the transitionend event
* Fixed: the cloned slides used for seamless looping could be inserted in the wrong order
* Added a menu icon for the plugin's admin menu entry


= 1.1.17 =

* Fixed: Modern engine was double-counting slide spacing (width % + margin-right), causing the track to overflow the viewport and reveal a sliver of the next slide on the right edge
* Modern engine now uses exact pixel widths with a single CSS gap for spacing between slides
* Fixed: fade mode (single visible slide) could still compute more than one slide's worth of width on wide screens


= 1.1.16 =

* New: Modern slider engine (Settings > Slider Engine) — a lightweight, dependency-free replacement for bxSlider with smoother touch/swipe, lazy-loaded images, and no jQuery requirement on the front end
* Existing sites automatically stay on the original Legacy (bxSlider) engine after updating — nothing changes on your live site unless you opt in
* New installs default to the Modern engine
* Slider Preview page now previews whichever engine is selected


= 1.1.15 =

* Security hardening: all database queries now use $wpdb->prepare() with parameterized values instead of direct string interpolation
* Fixed a gap in the mass-image-upload handler where the image title was not fully sanitized before being saved
* Sorting (order by) is now restricted to a fixed whitelist of columns to prevent unexpected input from reaching the query


= 1.1.14 =

* Fixed gif images not working


= 1.1.13 =

* Added webp image support


= 1.1.12 =

* Fixed E_Error – Too few arguments to function


= 1.1.11 =

* Make shortcode compitible with block editor
* Tested with WordPress 6.3


= 1.1.10 =

* Fixed vulnerability.
* Tested with WordPress 6.2


= 1.1.9 =

* Fixed, page not refreshed after adding mass images.
* Tested with WordPress 6.1


= 1.1.8 =

* Added mass image add feature
* Tested with WordPress 5.9


= 1.1.7 =

* Fixed touch and slider not working with latest updates of WordPress


= 1.1.6 =

* Fixed slider not working with jQuery 3.x


= 1.1.5 =

* Improve slider loading



= 1.1.4 =

* Make plugin compitible with lazy load
* Tested with WordPress 5.5



= 1.1.3 =

* Fixed vertical screen scroll not working when touch and scroll in mobile
* Removed jQuery.noConflict() as it cause problem when $ used


= 1.1.2 =

* Fixed undefined error on settings page.
* Tested with WordPress 5.3
* fixed slider loading initial page load, set slider hidden untile slider loaded.


= 1.1.1 =

* Fixed windows OS chrome browser click event not working properly.


= 1.1.0 =

* Fixed smartphone slider thumbnail link not working.


= 1.0.9 =

* bug fixes for latest Edge browser open 2 window on click of slider image.


= 1.0.8 =

* bug fixes for latest firefox open 2 window on click of slider image.
* Improve code so that plugin can continue work even jquery included into footer.
* Tested with WordPress 5.2


= 1.0.7 =

* bug fixes for chrome windows browser specific click event not work

= 1.0.6 =

* Fix issue of latest chrome browser touch not working properly



= 1.0.5 =

* Added wordpress capebilities feature. So that admin can set permissions

* Tested upto wordpress 5.1


= 1.0.4 =

* Added two new options into slider (show Caption, Show Pager)

* Tested upto wordpress 5.0


= 1.0.3 =

* make plugin translatable.

* Added shorting and searching in admin manage images.

* Tested upto wordpress 4.9

= 1.0.2 =

* Fixed for shortcode not working in widgets of wordpress 4.8

* Tested upto wordpress 4.8


= 1.0.1 =

* I notice that some host wan't allow url in copy function php so now it is fixed.

* Now support auto slider with arrow.

* Tested upto wordpress 4.6


= 1.0 =

* Stable 1.0 first release


== Upgrade notice ==

= 1.1.2 =

* Please clear browser as well as wp cache ( if you have installed ) after update.

= 1.1.1 =

* Please clear browser as well as wp cache ( if you have installed ) after update.


= 1.1.0 =

* Please clear browser as well as wp cache ( if you have installed ) after update.


= 1.0.8 =

* Please clear browser as well as wp cache ( if you have installed ) after update.


= 1.0.7 =

* Please clear browser as well as wp cache ( if you have installed ) after update.

= 1.0.6 =

* Please clear browser as well as wp cache ( if you have installed ) after update.

= 1.0.1 =

* Pro version please do not Upgrade here insted contact @ https://www.i13websolution.com/contacts

= 1.0 =

* Stable 1.0 first release


== Frequently asked questions ==

= How many sliders can I create with the free version? =

One. It's a great fit for a single homepage banner, gallery, or logo strip. If you need multiple independent sliders across your site, [Responsive Thumbnail Slider PRO](https://www.i13websolution.com/product/wordpress-responsive-thumbnail-html-slider-pro/) supports unlimited sliders.

= What's the difference between the Modern and Legacy engine? =

Modern is a lighter, dependency-free engine (no jQuery required for the slider itself), touch/swipe-friendly with lazy-loaded images. Legacy is the original engine, kept for sites that rely on its exact current behavior. Existing sites stay on Legacy automatically after updating — nothing changes on your live site unless you switch it yourself in Slider Settings.

= Will updating break my existing slider? =

No. Your slider keeps its current engine and all current settings after an update — nothing changes on your live site unless you explicitly change a setting yourself.

= How do I add the slider to a page? =

Use the shortcode `[print_responsive_thumbnail_slider]` in any page, post, or widget, or add it directly to a theme template with `do_shortcode()`. Gutenberg block editor support is also built in.

= Does the lightbox work with captions? =

Yes — when Show Caption is enabled, the caption also appears in the lightbox overlay when a slide is clicked.

= I need more control — border styling, per-image links, analytics, page builder support... =

That's what [Responsive Thumbnail Slider PRO](https://www.i13websolution.com/product/wordpress-responsive-thumbnail-html-slider-pro/) is for — see the Description tab above for the full feature list.
