# Dokumentasi Animasi Home Page

## Daftar Lengkap Animasi di `home.blade.php`

### 🎯 1. Hero Section
**Lokasi**: Baris 5-212

#### Animasi Background:
- **Parallax Background** (`parallax-bg`):
  - `bg-1`: Float animation 6s infinite (gradient biru-emas)
  - `bg-2`: Float animation 8s infinite reverse (gradient coklat-emas)
  - `bg-3`: Float animation 10s infinite (gradient emas-coklat)

- **Floating Particles** (`floating-particle`):
  - 6 partikel dengan `floatParticle` animation (8s linear infinite)
  - Delay: particle-1 (0s), particle-2 (1s), particle-3 (2s), particle-4 (3s), particle-5 (4s), particle-6 (5s)

#### Hero Carousel (3 Slide):
- **Slide Transition**: Fade in/out dengan `opacity` dan `visibility` (1s ease-in-out)
- **Slide 1**: 
  - Image: `slideInLeft` (1.2s ease-out 0.3s)
  - Title: `slideInLeft` (1s ease-out 0.2s)
  - Description: `slideInLeft` (1s ease-out 0.4s)
  - Buttons: `slideInLeft` (1s ease-out 0.6s)
  - Content: `.active` class trigger (0.8s cubic-bezier)
- **Slide 2**: 
  - Image: `slideInRight` (1.2s ease-out 0.3s)
  - Title: `slideInRight` (1s ease-out 0.2s)
  - Description: `slideInRight` (1s ease-out 0.4s)
  - Buttons: `slideInRight` (1s ease-out 0.6s)
- **Slide 3**: 
  - Image: `zoomIn` (1.2s ease-out 0.3s)
  - Title: `zoomIn` (1s ease-out 0.2s)
  - Description: `zoomIn` (1s ease-out 0.4s)
  - Buttons: `zoomIn` (1s ease-out 0.6s)

#### Hero Image Animation:
- `floatImage`: 6s ease-in-out infinite (naik-turun halus)
- 3D transform: `translateZ(50px) scale(1.05)` → `translateZ(60px) scale(1.08)` saat active

#### Scroll Indicator:
- `scroll-indicator`: Bounce animation (2s infinite)
- `animate-bounce` class dari Tailwind

#### Carousel Controls:
- Navigation buttons: Hover scale 1.1
- Indicators: Scale 1.4 saat active, scale 1.2 saat hover
- Auto-play: 6 detik per slide

---

### 📖 2. About Section
**Lokasi**: Baris 217-325

#### Section Header:
- **Heading**: `data-animate="fade-up"` dengan `data-stagger-step="90"`
- **Description**: `data-animate="fade-up"` dengan `data-stagger-step="90"`

#### Content Grid:
- **Image Container**: `data-animate="slide-right"` (800ms ease-out)
  - Image hover: `scale(1.05)` transition 500ms
  - Decorative blur circles: Static (bg-primary/20, bg-secondary/20)
  
- **Text Content**: `data-animate="slide-left"` (800ms ease-out)
  - Title dan description dengan stagger 100ms

#### Features Grid (4 cards):
- **Semua Cards**: `data-animate="scale-in"` dengan `data-stagger-step="80"`
- **Icon Hover**: Scale 1.1 dengan shadow-lg
- **Card Hover**: TranslateY(-5px)

---

### 🛠️ 3. Services Section
**Lokasi**: Baris 328-450

#### Section Header:
- **Heading**: `data-animate="fade-up"` dengan `data-stagger-step="90"`
- **Description**: `data-animate="fade-up"` dengan `data-stagger-step="90"`

#### Background Shapes:
- `service-bg-shape shape-1`: Rotate 20s linear infinite (kanan atas)
- `service-bg-shape shape-2`: Rotate 15s linear infinite reverse (kiri bawah)

#### Services Accordion:
- **Accordion Items**: `data-animate="fade-up"` dengan `data-stagger-step="120"`
- **Accordion Header Hover**: Background rgba(216, 155, 48, 0.02)
- **Accordion Item Active**: Shadow dan border-color berubah
- **Icon Rotation**: 180deg saat active
- **Content Expand**: Max-height transition 0.5s cubic-bezier

#### Pricing Cards (di dalam accordion):
- **Pricing Cards**: `data-animate="fade-up"` (scroll trigger saat accordion terbuka)
- **Card Hover**: 
  - TranslateY(-8px) scale(1.02)
  - Top border gradient muncul (scaleX 0 → 1)
- **Button Hover**: TranslateY(-2px) dengan shadow

---

### 💬 4. Testimonials Section
**Lokasi**: Baris 453-539

#### Section Header:
- **Heading**: `data-animate="fade-up"` dengan `data-stagger-step="90"`
- **Description**: `data-animate="fade-up"` dengan `data-stagger-step="90"`

#### Background Pattern:
- `testimonial-bg-pattern`: Radial gradient static

#### Testimonial Carousel:
- **Testimonial Slides**: `data-animate="scale-in"` dengan `data-stagger-step="120"`
- **Carousel Track**: Transform translateX dengan transition 0.6s cubic-bezier
- **Card Hover**: 
  - TranslateY(-8px)
  - Shadow meningkat
  - Top border gradient muncul (scaleX)
- **Auto-play**: 5 detik per slide
- **Controls**: Prev/Next buttons dengan hover scale 1.1
- **Indicators**: Scale 1.2 saat active

---

### 🏢 5. Client Logos Section
**Lokasi**: Baris 542-587

#### Section Header:
- **Heading**: `data-animate="fade-up"` dengan `data-stagger-step="90"`
- **Description**: `data-animate="fade-up"` dengan `data-stagger-step="90"`

#### Marquee Animation:
- **Marquee Left**: `marqueeLeft` 30s linear infinite
- **Marquee Right**: `marqueeRight` 30s linear infinite
- **Logo Hover**: 
  - Animation paused (`animation-play-state: paused`)
  - Opacity 0.8 → 1.0
  - Scale 1.0 → 1.1

---

### 👥 6. Team Section
**Lokasi**: Baris 590-645

#### Section Header:
- **Heading**: `data-animate="fade-up"` dengan `data-stagger-step="90"`
- **Description**: `data-animate="fade-up"` dengan `data-stagger-step="90"`

#### Team Cards Grid:
- **Team Cards**: `data-animate="scale-in"` dengan `data-stagger-step="80"`
- **Card Hover**: 
  - Shadow meningkat (shadow-lg)
  - Transition 300ms

---

### 📞 7. Contact Section
**Lokasi**: Baris 647-760

#### Section Header:
- **Heading**: `data-animate="fade-up"` dengan `data-stagger-step="90"`
- **Description**: `data-animate="fade-up"` dengan `data-stagger-step="90"`

#### Background Shapes:
- `contact-bg-shape shape-1`: Rotate 25s linear infinite (kiri atas)
- `contact-bg-shape shape-2`: Rotate 20s linear infinite reverse (kanan bawah)

#### Contact Grid:
- **Contact Info**: `data-animate="slide-right"` dengan `data-stagger-step="120"`
  - Info items hover: TranslateX(10px)
  
- **Contact Form**: `data-animate="slide-left"` dengan `data-stagger-step="120"`
  - Input focus: Scale 1.05
  - Button hover: Scale 1.05

#### Map Section:
- **Map Container**: `data-animate="fade-up"` (jika ada)

---

## 🎨 Varian Animasi yang Tersedia

### Data-Animate Variants:

1. **`fade-up`**: Opacity 0 → 1, translateY(24px) → 0
   - Duration: 800ms
   - Easing: cubic-bezier(0.4, 0, 0.2, 1)

2. **`fade-in`**: Opacity 0 → 1
   - Duration: 800ms
   - Easing: cubic-bezier(0.4, 0, 0.2, 1)

3. **`slide-left`**: Opacity 0 → 1, translateX(32px) → 0
   - Duration: 800ms
   - Easing: cubic-bezier(0.4, 0, 0.2, 1)

4. **`slide-right`**: Opacity 0 → 1, translateX(-32px) → 0
   - Duration: 800ms
   - Easing: cubic-bezier(0.4, 0, 0.2, 1)

5. **`scale-in`**: Opacity 0 → 1, scale(0.96) → 1
   - Duration: 800ms
   - Easing: cubic-bezier(0.4, 0, 0.2, 1)

6. **`flip-in`**: Opacity 0 → 1, perspective(800px) rotateX(-35deg) → 0
   - Duration: 800ms
   - Easing: cubic-bezier(0.4, 0, 0.2, 1)
   - Transform origin: top

7. **`glow-in`**: Opacity + filter blur(6px) brightness(1.2) → blur(0) brightness(1)
   - Duration: 800ms opacity, 1000ms filter
   - Easing: cubic-bezier(0.4, 0, 0.2, 1)

---

## ⚙️ Sistem Animasi

### Stagger System:
- Container dengan `data-stagger` akan memberikan delay bertahap ke child elements
- `data-stagger-step`: Delay per item (default: 80ms)
- `data-stagger-base`: Base delay sebelum stagger (default: 0ms)

### Intersection Observer:
- **Threshold**: 0.1 (10% element terlihat)
- **Root Margin**: `0px 0px -50px 0px` (trigger 50px sebelum masuk viewport)
- **Behavior**: 
  - Elemen ditandai dengan `will-animate` saat load
  - Saat masuk viewport, ditambahkan class `animate-in`
  - Observer di-unobserve setelah animasi trigger

### Reduced Motion Support:
- Jika user prefer reduced motion, semua animasi langsung apply `animate-in`
- Animasi background (parallax, particles, marquee) dinonaktifkan
- Durasi animasi dikurangi ke 0.001ms

---

## 🚀 Cara Menggunakan

### 1. Tambahkan Animasi ke Elemen:
```html
<div data-animate="fade-up">Konten yang akan di-animate</div>
```

### 2. Gunakan Stagger untuk Multiple Items:
```html
<div data-stagger data-stagger-step="100">
  <div data-animate="fade-up">Item 1</div>
  <div data-animate="fade-up">Item 2</div>
  <div data-animate="fade-up">Item 3</div>
</div>
```

### 3. Variant yang Bisa Digunakan:
- `fade-up` - Masuk dari bawah dengan fade
- `fade-in` - Fade sederhana
- `slide-left` - Masuk dari kanan
- `slide-right` - Masuk dari kiri
- `scale-in` - Zoom dari kecil ke besar
- `flip-in` - Rotate X flip effect
- `glow-in` - Blur + brightness effect

---

## 📝 Catatan Teknis

### JavaScript Initialization:
- File: `resources/js/landing.js`
- Inisialisasi: `DOMContentLoaded` event
- Functions:
  - `initScrollAnimations()`: Setup IntersectionObserver
  - `initHeroCarousel()`: Hero carousel dengan auto-play
  - `initTestimonialCarousel()`: Testimonial carousel dengan auto-play

### CSS Variables:
```css
--anim-ease: cubic-bezier(0.4, 0, 0.2, 1);
--anim-duration: 800ms;
--anim-stagger-step: 80ms;
```

### Build Process:
1. File source: `resources/css/app.css`, `resources/js/landing.js`
2. Build command: `npm run build`
3. Output: `public/build/assets/app-*.css` dan `app-*.js`

---

## ✅ Checklist Animasi

- [x] Hero carousel dengan 3 slide
- [x] Parallax background di hero
- [x] Floating particles
- [x] Scroll indicator
- [x] About section (fade-up, slide-left/right)
- [x] Features grid (scale-in dengan stagger)
- [x] Services accordion (fade-up dengan stagger)
- [x] Pricing cards (fade-up)
- [x] Testimonials carousel (scale-in dengan stagger)
- [x] Client logos marquee (auto-play dengan hover pause)
- [x] Team cards (scale-in dengan stagger)
- [x] Contact section (slide-left/right)
- [x] Map section (fade-up)
- [x] Hover effects di semua interactive elements
- [x] Reduced motion support

---

**Status**: ✅ Semua animasi sudah diimplementasikan dan build berhasil!

