/**
 * Responsive Thumbnail Slider - Modern Engine
 * Dependency-free replacement for the legacy bxSlider engine.
 * No jQuery required for slider mechanics.
 */
(function () {
	'use strict';

	function RTSModernSlider(root) {
		this.root = root;
		this.viewport = root.querySelector('.rts-modern-viewport');
		this.track = root.querySelector('.rts-modern-track');
		this.slides = Array.prototype.slice.call(root.querySelectorAll('.rts-modern-slide'));
		this.realCount = this.slides.length;

		var settingsRaw = root.getAttribute('data-settings');
		this.settings = settingsRaw ? JSON.parse(settingsRaw) : {};

		this.visible = Math.max(1, parseInt(this.settings.visible, 10) || 1);
		this.minVisible = Math.max(1, parseInt(this.settings.minVisible, 10) || 1);
		this.scroll = Math.max(1, parseInt(this.settings.scroll, 10) || 1);
		this.margin = parseInt(this.settings.margin, 10) || 0;
		this.speed = parseInt(this.settings.speed, 10) || 500;
		this.pauseMs = parseInt(this.settings.pause, 10) || 4000;
		this.auto = parseInt(this.settings.auto, 10) || 0; // 0 = off, 1 = auto (no arrows), 2 = auto (with arrows)
		this.pauseOnHover = !!this.settings.pauseOnHover;
		this.circular = !!this.settings.circular;
		this.showPager = !!this.settings.showPager;
		this.fade = this.visible === 1 && !!this.settings.fade;

		this.effectiveVisible = this.visible;
		this.index = 0; // index into the (possibly cloned) slide list
		this.timer = null;
		this.pendingSnap = false;
		this.snapTimeout = null;

		if (this.realCount === 0) {
			return;
		}

		this._buildClones();
		this._buildControls();
		this._recalc();
		this._bindEvents();

		if (this.auto === 1 || this.auto === 2) {
			this._startAutoplay();
		}
	}

	RTSModernSlider.prototype._buildClones = function () {
		if (!this.circular || this.realCount <= this.visible || this.fade) {
			this.cloneCount = 0;
			return;
		}

		this.cloneCount = this.visible;

		var headClones = this.slides.slice(0, this.cloneCount).map(function (el) {
			var clone = el.cloneNode(true);
			clone.setAttribute('aria-hidden', 'true');
			clone.classList.add('rts-modern-clone');
			return clone;
		});
		var tailClones = this.slides.slice(-this.cloneCount).map(function (el) {
			var clone = el.cloneNode(true);
			clone.setAttribute('aria-hidden', 'true');
			clone.classList.add('rts-modern-clone');
			return clone;
		});

		var beforeNode = this.track.firstChild;
		tailClones.forEach(function (clone) {
			this.track.insertBefore(clone, beforeNode);
		}, this);
		headClones.forEach(function (clone) {
			this.track.appendChild(clone);
		}, this);

		this.index = this.cloneCount;
	};

	RTSModernSlider.prototype._buildControls = function () {
		var self = this;

		if (this.auto !== 1) {
			this.prevBtn = document.createElement('button');
			this.prevBtn.type = 'button';
			this.prevBtn.className = 'rts-modern-arrow rts-modern-prev';
			this.prevBtn.setAttribute('aria-label', 'Previous');
			this.prevBtn.innerHTML = '&#10094;';

			this.nextBtn = document.createElement('button');
			this.nextBtn.type = 'button';
			this.nextBtn.className = 'rts-modern-arrow rts-modern-next';
			this.nextBtn.setAttribute('aria-label', 'Next');
			this.nextBtn.innerHTML = '&#10095;';

			this.root.appendChild(this.prevBtn);
			this.root.appendChild(this.nextBtn);

			this.prevBtn.addEventListener('click', function () { self._userNav(-1); });
			this.nextBtn.addEventListener('click', function () { self._userNav(1); });
		}

		if (this.showPager && this.realCount > this.visible) {
			this.pagerWrap = document.createElement('div');
			this.pagerWrap.className = 'rts-modern-pager';
			this.root.appendChild(this.pagerWrap);

			var pages = Math.ceil(this.realCount / this.scroll);
			this.pagerDots = [];
			for (var p = 0; p < pages; p++) {
				(function (pageIndex) {
					var dot = document.createElement('button');
					dot.type = 'button';
					dot.className = 'rts-modern-dot';
					dot.setAttribute('aria-label', 'Go to slide ' + (pageIndex + 1));
					dot.addEventListener('click', function () {
						self._goTo(self.cloneCount + pageIndex * self.scroll, true);
					});
					self.pagerWrap.appendChild(dot);
					self.pagerDots.push(dot);
				})(p);
			}
		}
	};

	RTSModernSlider.prototype._recalc = function () {
		var availableWidth = (this.root.parentElement ? this.root.parentElement.clientWidth : this.viewport.clientWidth) || this.viewport.clientWidth;
		var configuredWidth = Math.max(1, parseInt(this.settings.slideWidth, 10) || 120);

		this.track.style.gap = this.margin + 'px';

		if (this.fade) {
			this.effectiveVisible = 1;
			this.currentSlideWidthPx = Math.min(configuredWidth, availableWidth);
		} else {
			var fit = Math.max(1, Math.floor((availableWidth + this.margin) / (configuredWidth + this.margin)));
			this.effectiveVisible = Math.max(this.minVisible, Math.min(this.visible, fit));
			this.currentSlideWidthPx = configuredWidth; // honor the configured thumbnail width instead of stretching to fill
		}

		var slideList = this.track.querySelectorAll('.rts-modern-slide');
		for (var i = 0; i < slideList.length; i++) {
			slideList[i].style.flex = '0 0 ' + this.currentSlideWidthPx + 'px';
			slideList[i].style.width = this.currentSlideWidthPx + 'px';
		}

		// Size the widget itself to exactly "effectiveVisible" slides so the browser
		// can't show a partial extra slide just because the parent column is wider.
		var desiredWidth = this.effectiveVisible * this.currentSlideWidthPx + Math.max(0, this.effectiveVisible - 1) * this.margin;
		this.root.style.width = Math.min(desiredWidth, availableWidth) + 'px';

		this._applyPosition(false);
	};

	RTSModernSlider.prototype._slideStep = function () {
		return (this.currentSlideWidthPx || 0) + this.margin;
	};

	RTSModernSlider.prototype._applyPosition = function (animate) {
		if (this.fade) {
			var all = this.track.querySelectorAll('.rts-modern-slide');
			if (animate) {
				void this.track.offsetHeight;
			}
			for (var i = 0; i < all.length; i++) {
				all[i].style.transition = animate ? 'opacity ' + this.speed + 'ms ease' : 'none';
				all[i].style.opacity = (i === this.index) ? '1' : '0';
				all[i].style.position = 'absolute';
				all[i].style.left = '0';
				all[i].style.top = '0';
			}
			this._updatePager();
			return;
		}

		var offset = this.index * this._slideStep();

		if (animate) {
			// Force a reflow so the browser commits any just-applied instant (non-animated)
			// state — e.g. the invisible loop-reset jump — before this transition starts.
			// Without this, two rapid consecutive style writes can get coalesced by the
			// browser, which never paints the "from" state and the transition silently
			// doesn't animate (looks like an instant jump instead of a slide).
			void this.track.offsetHeight;
			this.track.style.transition = 'transform ' + this.speed + 'ms ease';
		} else {
			this.track.style.transition = 'none';
		}

		this.track.style.transform = 'translateX(-' + offset + 'px)';
		this._updatePager();
	};

	RTSModernSlider.prototype._updatePager = function () {
		if (!this.pagerDots) return;
		var realIndex = ((this.index - this.cloneCount) % this.realCount + this.realCount) % this.realCount;
		var page = Math.floor(realIndex / this.scroll);
		this.pagerDots.forEach(function (dot, i) {
			dot.classList.toggle('rts-modern-dot-active', i === page);
		});
	};

	RTSModernSlider.prototype._goTo = function (index, animate) {
		// _goTo (pager clicks) is an explicit, authoritative navigation. If a loop-reset
		// was still pending from a recent arrow/autoplay move, it must not be allowed to
		// fire afterward and silently override this — cancel it instead.
		if (this.pendingSnap) {
			this.pendingSnap = false;
			if (this.snapTimeout) {
				window.clearTimeout(this.snapTimeout);
				this.snapTimeout = null;
			}
		}

		this.index = index;
		this._applyPosition(animate !== false);
	};

	RTSModernSlider.prototype._userNav = function (dir) {
		this._restartAutoplay();
		this._move(dir);
	};

	RTSModernSlider.prototype._move = function (dir) {
		if (this.fade) {
			this.index = ((this.index + dir) % this.realCount + this.realCount) % this.realCount;
			this._applyPosition(true);
			return;
		}

		if (this.pendingSnap) {
			return; // avoid stacking moves while a loop-reset is in flight
		}

		this.index += dir * this.scroll;

		if (this.circular && this.cloneCount > 0) {
			// The clone buffer only extends cloneCount slides past each end of the real
			// content — a scroll step larger than 1 can jump straight past that buffer in
			// a single move (especially backward, which has zero cushion below index 0;
			// there is no DOM content at all before the first clone). Clamp to the buffer's
			// true extent before ever rendering, so we never attempt to show a position
			// that doesn't exist regardless of how big the scroll step is.
			var minIndex = 0;
			var maxIndex = this.cloneCount + this.realCount + this.cloneCount - this.effectiveVisible;
			if (this.index < minIndex) this.index = minIndex;
			if (this.index > maxIndex) this.index = maxIndex;
		}

		this._applyPosition(true);

		if (!this.circular || this.cloneCount === 0) {
			var maxNonCircularIndex = Math.max(0, this.realCount - this.effectiveVisible);
			if (this.index < 0) this.index = 0;
			if (this.index > maxNonCircularIndex) this.index = maxNonCircularIndex;
			return;
		}

		// The clone buffer on each side holds exactly cloneCount slides, at fixed DOM
		// positions [0, cloneCount-1] (tail clones) and [cloneCount+realCount, cloneCount+realCount+cloneCount-1]
		// (head clones) — these bounds are NOT scaled by realCount. Using cloneCount-realCount
		// here previously went deeply negative whenever realCount > cloneCount (the normal
		// case), letting backward navigation travel into DOM positions where no clone
		// actually exists, which is why only the "previous" direction could get stuck.
		var lower = 0;
		var upper = this.cloneCount + this.realCount;

		if (this.index >= upper || this.index <= lower) {
			this._scheduleSnap();
		}
	};

	RTSModernSlider.prototype._scheduleSnap = function () {
		var self = this;
		this.pendingSnap = true;

		if (this.snapTimeout) {
			window.clearTimeout(this.snapTimeout);
		}

		// transitionend is the normal trigger, but it can be missed entirely — e.g. a
		// window resize interrupts the transition right as the loop boundary is crossed.
		// Without a fallback, a single missed event leaves pendingSnap stuck true forever,
		// silently blocking all further arrow clicks and autoplay ticks. This guarantees
		// the snap always completes even if that event never fires.
		this.snapTimeout = window.setTimeout( function () {
			self._performSnap();
		}, this.speed + 150 );
	};

	RTSModernSlider.prototype._performSnap = function () {
		if (!this.pendingSnap) return;

		this.pendingSnap = false;
		if (this.snapTimeout) {
			window.clearTimeout(this.snapTimeout);
			this.snapTimeout = null;
		}

		this.index = this.cloneCount + (((this.index - this.cloneCount) % this.realCount + this.realCount) % this.realCount);
		this._applyPosition(false);
	};

	RTSModernSlider.prototype._handleTransitionEnd = function (e) {
		if (e && e.target !== this.track) return;
		if (e && e.propertyName && e.propertyName !== 'transform') return;
		this._performSnap();
	};

	RTSModernSlider.prototype._startAutoplay = function () {
		var self = this;
		this.timer = window.setInterval(function () { self._move(1); }, this.pauseMs);
	};

	RTSModernSlider.prototype._stopAutoplay = function () {
		if (this.timer) {
			window.clearInterval(this.timer);
			this.timer = null;
		}
	};

	RTSModernSlider.prototype._restartAutoplay = function () {
		if (this.auto === 1 || this.auto === 2) {
			this._stopAutoplay();
			this._startAutoplay();
		}
	};

	RTSModernSlider.prototype._bindEvents = function () {
		var self = this;

		this.track.addEventListener('transitionend', function (e) { self._handleTransitionEnd(e); });

		if (this.pauseOnHover && (this.auto === 1 || this.auto === 2)) {
			this.root.addEventListener('mouseenter', function () { self._stopAutoplay(); });
			this.root.addEventListener('mouseleave', function () { self._startAutoplay(); });
		}

		window.addEventListener('resize', debounce(function () { self._recalc(); }, 150));

		// Basic touch/swipe support.
		var startX = 0, deltaX = 0, dragging = false;

		this.track.addEventListener('touchstart', function (e) {
			dragging = true;
			startX = e.touches[0].clientX;
		}, { passive: true });

		this.track.addEventListener('touchmove', function (e) {
			if (!dragging) return;
			deltaX = e.touches[0].clientX - startX;
		}, { passive: true });

		this.track.addEventListener('touchend', function () {
			if (!dragging) return;
			dragging = false;
			if (Math.abs(deltaX) > 40) {
				self._userNav(deltaX < 0 ? 1 : -1);
			}
			deltaX = 0;
		});
	};

	function debounce(fn, wait) {
		var t;
		return function () {
			var args = arguments, ctx = this;
			window.clearTimeout(t);
			t = window.setTimeout(function () { fn.apply(ctx, args); }, wait);
		};
	}

	function initAll() {
		var nodes = document.querySelectorAll('.rts-modern-slider:not([data-rts-inited])');
		for (var i = 0; i < nodes.length; i++) {
			nodes[i].setAttribute('data-rts-inited', '1');
			new RTSModernSlider(nodes[i]);
		}
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initAll);
	} else {
		initAll();
	}

	window.RTSModernSlider = RTSModernSlider;
})();
