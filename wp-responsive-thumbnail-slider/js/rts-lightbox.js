/**
 * Responsive Thumbnail Slider - Lightbox
 * Dependency-free overlay for viewing full-size images. No jQuery required.
 */
(function () {
	'use strict';

	var overlay = null;
	var currentGroup = [];
	var currentIndex = 0;

	function buildOverlay() {
		if (overlay) return overlay;

		overlay = document.createElement('div');
		overlay.className = 'rts-lightbox-overlay';
		overlay.setAttribute('aria-hidden', 'true');
		overlay.innerHTML =
			'<button type="button" class="rts-lightbox-close" aria-label="Close">&times;</button>' +
			'<button type="button" class="rts-lightbox-prev" aria-label="Previous">&#10094;</button>' +
			'<div class="rts-lightbox-stage"><img class="rts-lightbox-img" alt="" /><div class="rts-lightbox-caption"></div></div>' +
			'<button type="button" class="rts-lightbox-next" aria-label="Next">&#10095;</button>';

		document.body.appendChild(overlay);

		overlay.querySelector('.rts-lightbox-close').addEventListener('click', close);
		overlay.querySelector('.rts-lightbox-prev').addEventListener('click', function () { show(currentIndex - 1); });
		overlay.querySelector('.rts-lightbox-next').addEventListener('click', function () { show(currentIndex + 1); });

		overlay.addEventListener('click', function (e) {
			if (e.target === overlay) close();
		});

		document.addEventListener('keydown', function (e) {
			if (!overlay || !overlay.classList.contains('rts-lightbox-open')) return;
			if (e.key === 'Escape') close();
			if (e.key === 'ArrowLeft') show(currentIndex - 1);
			if (e.key === 'ArrowRight') show(currentIndex + 1);
		});

		return overlay;
	}

	function show(index) {
		if (!currentGroup.length) return;
		currentIndex = ((index % currentGroup.length) + currentGroup.length) % currentGroup.length;
		var item = currentGroup[currentIndex];
		var img = overlay.querySelector('.rts-lightbox-img');
		var caption = overlay.querySelector('.rts-lightbox-caption');
		img.src = item.full;
		img.alt = item.caption || '';
		caption.textContent = item.caption || '';

		var multi = currentGroup.length > 1;
		overlay.querySelector('.rts-lightbox-prev').style.display = multi ? '' : 'none';
		overlay.querySelector('.rts-lightbox-next').style.display = multi ? '' : 'none';
	}

	function open(group, index) {
		buildOverlay();
		currentGroup = group;
		show(index);
		overlay.classList.add('rts-lightbox-open');
		overlay.setAttribute('aria-hidden', 'false');
		document.body.classList.add('rts-lightbox-locked');
	}

	function close() {
		if (!overlay) return;
		overlay.classList.remove('rts-lightbox-open');
		overlay.setAttribute('aria-hidden', 'true');
		document.body.classList.remove('rts-lightbox-locked');
	}

	function collectGroup(trigger) {
		var groupId = trigger.getAttribute('data-lightbox-group');
		var triggers = groupId
			? document.querySelectorAll('[data-lightbox-trigger="1"][data-lightbox-group="' + groupId + '"]')
			: [trigger];

		var group = [];
		var index = 0;
		for (var i = 0; i < triggers.length; i++) {
			if (triggers[i] === trigger) index = i;
			group.push({
				full: triggers[i].getAttribute('data-lightbox-full') || triggers[i].getAttribute('href'),
				caption: triggers[i].getAttribute('data-lightbox-caption') || '',
			});
		}
		return { group: group, index: index };
	}

	document.addEventListener('click', function (e) {
		var trigger = e.target.closest ? e.target.closest('[data-lightbox-trigger="1"]') : null;
		if (!trigger) return;

		e.preventDefault();
		var result = collectGroup(trigger);
		open(result.group, result.index);
	});
})();
