/* Landing page interactions: hero carousel, testimonial carousel, scroll animations, a11y, reduced-motion */

function initReducedMotion() {
  try {
    return window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  } catch (_) {
    return false;
  }
}

// Utilities
function throttle(fn, wait) {
  let last = 0;
  return function (...args) {
    const now = Date.now();
    if (now - last >= wait) {
      last = now;
      fn.apply(this, args);
    }
  };
}

// Scroll-triggered animations
function initScrollAnimations(reducedMotion) {
  if (reducedMotion) {
    document.querySelectorAll('.animate-on-scroll, .animate-on-scroll-delay, .animate-on-scroll-delay-2')
      .forEach(el => el.classList.add('animate-in'));
    document.querySelectorAll('[data-animate]')
      .forEach(el => el.classList.add('animate-in'));
    return;
  }

  // Mark elements to be animated (so default CSS is not hiding anything until JS runs)
  document.querySelectorAll('.animate-on-scroll, .animate-on-scroll-delay, .animate-on-scroll-delay-2, [data-animate]')
    .forEach(el => {
      el.classList.add('will-animate');
      if (el.classList.contains('animate-on-scroll-delay')) el.classList.add('delay-1');
      if (el.classList.contains('animate-on-scroll-delay-2')) el.classList.add('delay-2');
    });
  const observer = new IntersectionObserver((entries, obs) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        // If the element uses data-animate, applying animate-in will transition to final state
        entry.target.classList.add('animate-in');
        entry.target.classList.remove('will-animate', 'delay-1', 'delay-2');
        obs.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

  // Apply stagger inside any container marked with data-stagger
  document.querySelectorAll('[data-stagger]')
    .forEach(container => {
      const base = Number(container.getAttribute('data-stagger-base') || 0);
      const step = Number(container.getAttribute('data-stagger-step') || 80);
      const children = container.querySelectorAll('.animate-on-scroll, .animate-on-scroll-delay, .animate-on-scroll-delay-2, [data-animate]');
      children.forEach((child, idx) => {
        const delayMs = base + idx * step;
        child.style.transitionDelay = `${delayMs}ms`;
      });
    });

  document.querySelectorAll('.animate-on-scroll, .animate-on-scroll-delay, .animate-on-scroll-delay-2, [data-animate]')
    .forEach(el => observer.observe(el));
}

// Animate.css on-scroll using IntersectionObserver
function initAnimateCssOnScroll(reducedMotion) {
  const targets = document.querySelectorAll('[data-animate], .animate-when-visible');
  if (targets.length === 0) return;

  if (reducedMotion) {
    targets.forEach(el => el.classList.add('animate-in'));
    return;
  }

  // Optional stagger container support
  document.querySelectorAll('[data-stagger]')
    .forEach(container => {
      const base = Number(container.getAttribute('data-stagger-base') || 0);
      const step = Number(container.getAttribute('data-stagger-step') || 80);
      const children = container.querySelectorAll('[data-animate], .animate-when-visible');
      children.forEach((child, idx) => {
        const existingDelay = child.getAttribute('data-delay');
        if (!existingDelay) {
          child.setAttribute('data-delay', `${base + idx * step}ms`);
        }
      });
    });

  const observer = new IntersectionObserver((entries, obs) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      const el = entry.target;

      // Skip if already animated
      if (el.classList.contains('animate__animated')) {
        obs.unobserve(el);
        return;
      }

      const effect = el.getAttribute('data-animate') || 'fadeInUp';
      const delay = el.getAttribute('data-delay');
      const duration = el.getAttribute('data-duration');

      if (delay) el.style.setProperty('--animate-delay', delay);
      if (duration) el.style.setProperty('--animate-duration', duration);

      // Clear pre-animate inline styles once animation starts/ends
      const clearInline = () => {
        el.style.removeProperty('opacity');
        el.style.removeProperty('transform');
        el.removeEventListener('animationend', clearInline);
      };
      el.addEventListener('animationend', clearInline, { once: true });

      el.classList.add('animate__animated', `animate__${effect}`);
      obs.unobserve(el);
    });
  }, { threshold: 0.15, rootMargin: '0px 0px -10% 0px' });

  targets.forEach(el => {
    // Set initial subtle offset and opacity for a guaranteed visual transition
    el.style.opacity = '0';
    el.style.transform = 'translateY(10px)';
    observer.observe(el);
  });
}

// Hero carousel
function initHeroCarousel(reducedMotion) {
  const container = document.querySelector('.hero-full-carousel');
  if (!container) return;

  const slides = Array.from(document.querySelectorAll('.hero-full-slide'));
  const indicatorsContainer = document.getElementById('heroCarouselIndicators');
  let current = 0;
  let intervalId;
  const AUTO_INTERVAL_MS = 5000;

  // A11y roles
  container.setAttribute('role', 'region');
  container.setAttribute('aria-roledescription', 'carousel');
  container.setAttribute('aria-label', 'Hero');
  container.setAttribute('tabindex', '0');

  function update() {
    slides.forEach((slide, idx) => {
      slide.classList.toggle('active', idx === current);
      const content = slide.querySelector('.hero-slide-content');
      if (content) {
        content.classList.toggle('active', idx === current);
      }
    });
    const indicators = indicatorsContainer ? Array.from(indicatorsContainer.querySelectorAll('button')) : [];
    indicators.forEach((btn, idx) => {
      btn.classList.toggle('active', idx === current);
      btn.setAttribute('aria-selected', idx === current ? 'true' : 'false');
    });
  }

  function goTo(idx) {
    current = (idx + slides.length) % slides.length;
    update();
  }
  function next() { goTo(current + 1); }
  function prev() { goTo(current - 1); }

  // Build indicators
  if (indicatorsContainer) {
    indicatorsContainer.innerHTML = '';
    slides.forEach((_, i) => {
      const btn = document.createElement('button');
      btn.className = 'hero-full-carousel-indicator';
      btn.setAttribute('aria-label', `Slide ${i + 1}`);
      btn.setAttribute('role', 'tab');
      btn.onclick = () => goTo(i);
      indicatorsContainer.appendChild(btn);
    });
  }

  // Controls
  const prevBtn = document.querySelector('.hero-full-carousel-prev');
  const nextBtn = document.querySelector('.hero-full-carousel-next');
  prevBtn && (prevBtn.onclick = () => { prev(); resetAuto(); });
  nextBtn && (nextBtn.onclick = () => { next(); resetAuto(); });

  // Keyboard
  container.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') { e.preventDefault(); prev(); resetAuto(); }
    if (e.key === 'ArrowRight') { e.preventDefault(); next(); resetAuto(); }
  });

  // Swipe (basic)
  let touchX = null;
  container.addEventListener('touchstart', (e) => {
    touchX = e.changedTouches[0].clientX;
  }, { passive: true });
  container.addEventListener('touchend', (e) => {
    if (touchX == null) return;
    const dx = e.changedTouches[0].clientX - touchX;
    if (Math.abs(dx) > 40) {
      (dx < 0 ? next : prev)();
      resetAuto();
    }
    touchX = null;
  });

  function startAuto() {
    if (reducedMotion) return;
    if (intervalId) return;
    intervalId = setInterval(() => { next(); }, AUTO_INTERVAL_MS);
  }
  function stopAuto() { if (intervalId) { clearInterval(intervalId); intervalId = null; } }
  function resetAuto() { stopAuto(); startAuto(); }

  // Pause on hover/focus
  container.addEventListener('mouseenter', stopAuto);
  container.addEventListener('mouseleave', startAuto);
  container.addEventListener('focusin', stopAuto);
  container.addEventListener('focusout', startAuto);

  update();
  startAuto();
}

// Testimonial carousel
function initTestimonialCarousel(reducedMotion) {
  const track = document.getElementById('testimonialTrack');
  if (!track) return;
  const slides = Array.from(document.querySelectorAll('.testimonial-slide'));
  if (slides.length === 0) return;

  let current = 0;
  const slidesToShow = 3;
  let maxSlides = Math.max(1, slides.length - slidesToShow + 1);
  let intervalId;
  const AUTO_INTERVAL_MS = 6000;

  function update() {
    const slideWidth = slides[0].offsetWidth;
    track.style.transform = `translateX(${-current * slideWidth}px)`;
    const indicators = Array.from(document.querySelectorAll('.testimonial-indicator'));
    indicators.forEach((el, idx) => el.classList.toggle('active', idx === current));
  }
  function next() { current = (current + 1) % maxSlides; update(); }
  function prev() { current = (current - 1 + maxSlides) % maxSlides; update(); }

  // Controls
  const prevBtn = document.querySelector('.testimonial-prev-btn');
  const nextBtn = document.querySelector('.testimonial-next-btn');
  prevBtn && (prevBtn.onclick = () => { prev(); resetAuto(); });
  nextBtn && (nextBtn.onclick = () => { next(); resetAuto(); });

  // Resize handling
  const onResize = throttle(() => { maxSlides = Math.max(1, slides.length - slidesToShow + 1); update(); }, 100);
  window.addEventListener('resize', onResize);
  if ('ResizeObserver' in window) {
    const ro = new ResizeObserver(onResize);
    ro.observe(track);
    slides.forEach(s => ro.observe(s));
  }

  function startAuto() {
    if (reducedMotion) return;
    if (intervalId) return;
    intervalId = setInterval(() => { next(); }, AUTO_INTERVAL_MS);
  }
  function stopAuto() { if (intervalId) { clearInterval(intervalId); intervalId = null; } }
  function resetAuto() { stopAuto(); startAuto(); }

  // Pause on hover/focus
  const container = document.querySelector('.testimonial-carousel-container');
  if (container) {
    container.addEventListener('mouseenter', stopAuto);
    container.addEventListener('mouseleave', startAuto);
    container.addEventListener('focusin', stopAuto);
    container.addEventListener('focusout', startAuto);
  }

  // Swipe (basic)
  let touchX = null;
  track.addEventListener('touchstart', (e) => { touchX = e.changedTouches[0].clientX; }, { passive: true });
  track.addEventListener('touchend', (e) => {
    if (touchX == null) return;
    const dx = e.changedTouches[0].clientX - touchX;
    if (Math.abs(dx) > 40) { (dx < 0 ? next : prev)(); resetAuto(); }
    touchX = null;
  });

  update();
  startAuto();
}

document.addEventListener('DOMContentLoaded', function () {
  // Mark body so CSS hides scroll-animate only when JS is active
  document.body.classList.add('js-anim');
  const reducedMotion = initReducedMotion();
  // Our custom animate.css on-scroll
  initAnimateCssOnScroll(reducedMotion);
  initHeroCarousel(reducedMotion);
  initTestimonialCarousel(reducedMotion);

  // Auto-hide swipe hints on first interaction
  const wrappers = Array.from(document.querySelectorAll('.products-scroll-wrapper'));
  wrappers.forEach(w => {
    const off = () => { w.classList.add('hint-off'); w.removeEventListener('scroll', off); w.removeEventListener('touchstart', off); w.removeEventListener('mousedown', off); };
    w.addEventListener('scroll', off, { passive: true });
    w.addEventListener('touchstart', off, { passive: true });
    w.addEventListener('mousedown', off);
  });

  // Init products dots indicator (mobile)
  initProductsDots();

  // Product Stories (mobile)
  initProductStories();
});

function initProductStories() {
  const isMobile = window.matchMedia('(max-width: 768px)').matches;
  if (!isMobile) return;
  document.querySelectorAll('.pricing-card').forEach(card => {
    card.addEventListener('click', () => openStoryViewer(card.getAttribute('data-service-id')));
  });
}

function initProductsDots() {
  const isMobile = window.matchMedia('(max-width: 768px)').matches;
  if (!isMobile) return;
  document.querySelectorAll('.products-dots').forEach(dots => {
    const serviceId = dots.getAttribute('data-service-id');
    const wrapper = document.getElementById(`products-${serviceId}`);
    if (!wrapper) return;
    const cards = wrapper.querySelectorAll('.pricing-card');
    const btns = Array.from(dots.querySelectorAll('.products-dot'));

    const updateActive = () => {
      const cardWidth = cards[0]?.offsetWidth || 1;
      const idx = Math.round(wrapper.scrollLeft / (cardWidth + 24)); // 24 ~ gap
      btns.forEach((b, i) => b.classList.toggle('active', i === idx));
    };

    wrapper.addEventListener('scroll', throttle(updateActive, 100), { passive: true });
    updateActive();

    // Click on dot to scroll
    btns.forEach(b => b.addEventListener('click', () => {
      const i = Number(b.getAttribute('data-idx')) || 0;
      const cardWidth = cards[0]?.offsetWidth || 1;
      wrapper.scrollTo({ left: i * (cardWidth + 24), behavior: 'smooth' });
    }));
  });
}

function openStoryViewer(serviceId) {
  const container = document.querySelector(`#accordion-${serviceId} .products-grid`);
  if (!container) return;
  const cards = Array.from(container.querySelectorAll('.pricing-card'));
  const products = cards.map(c => {
    const title = c.querySelector('.pricing-card-title')?.textContent?.trim() || '';
    const price = c.querySelector('.price-amount')?.textContent?.trim() || '';
    const desc = c.querySelector('.pricing-card-description')?.textContent?.trim() || '';
    const image = c.getAttribute('data-image') || '';
    return { title, price, desc, image };
  });
  buildStoryOverlay(products);
}

function buildStoryOverlay(items) {
  let idx = 0; let timer = null; const DURATION = 4000;
  const overlay = document.createElement('div'); overlay.className = 'story-overlay active';
  overlay.innerHTML = `
    <div class="story-progress">${items.map(() => '<div class="story-segment"><span></span></div>').join('')}</div>
    <button class="story-close" aria-label="Tutup">✕</button>
    <div class="story-tap-left"></div>
    <div class="story-tap-right"></div>
    <div class="story-content"><div class="story-inner"><div class="story-media"></div><div class="story-meta"></div></div></div>
  `;
  document.body.appendChild(overlay);
  const inner = overlay.querySelector('.story-inner');
  const media = overlay.querySelector('.story-media');
  const meta = overlay.querySelector('.story-meta');
  const segs = Array.from(overlay.querySelectorAll('.story-segment > span'));

  const render = () => {
    const item = items[idx];
    // Render media (image only for now)
    media.innerHTML = item.image ? `<img src="${item.image}" alt="${item.title}">` : '';
    meta.innerHTML = `
      <div class="story-title">${item.title}</div>
      <div class="story-price">${item.price}</div>
      ${item.desc ? `<div class="story-desc">${item.desc}</div>` : ''}
    `;
    segs.forEach((s, i) => { s.style.transitionDuration = '0ms'; s.style.width = i < idx ? '100%' : '0%'; });
    requestAnimationFrame(() => {
      segs[idx].style.transitionDuration = DURATION + 'ms';
      segs[idx].style.width = '100%';
    });
    clearTimeout(timer);
    timer = setTimeout(next, DURATION);
  };

  const next = () => { idx = (idx + 1); if (idx >= items.length) return close(); render(); };
  const prev = () => { idx = Math.max(0, idx - 1); render(); };
  const close = () => { clearTimeout(timer); overlay.remove(); };

  overlay.querySelector('.story-close')?.addEventListener('click', close);
  overlay.querySelector('.story-tap-right')?.addEventListener('click', () => { clearTimeout(timer); next(); });
  overlay.querySelector('.story-tap-left')?.addEventListener('click', () => { clearTimeout(timer); prev(); });

  // Basic swipe-down to close
  let startY = null; overlay.addEventListener('touchstart', e => { startY = e.touches[0].clientY; }, { passive: true });
  overlay.addEventListener('touchend', e => { if (startY != null && e.changedTouches[0].clientY - startY > 80) close(); startY = null; }, { passive: true });

  render();
}

window.addEventListener('load', function () {
  document.body.classList.add('loaded');
});


