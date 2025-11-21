# Analisis Performa Lighthouse - Skor 50

## Masalah yang Ditemukan

### 1. **Render-Blocking Resources (Critical)**
- **Google Fonts dari external CDN** - Import di `app.css` line 2:
  ```css
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Poppins:wght@400;500;600;700&display=swap');
  ```
  - **Masalah**: Blocking render, tidak ada preconnect
  - **Dampak**: Menunda First Contentful Paint (FCP) dan Largest Contentful Paint (LCP)

- **AOS CSS dari unpkg** - Di `frontend.blade.php` line 28:
  ```html
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  ```
  - **Masalah**: External CSS blocking render
  - **Dampak**: Menunda rendering

### 2. **JavaScript Blocking (Critical)**
- **AOS JS dari unpkg** - Di `frontend.blade.php` line 318:
  ```html
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  ```
  - **Masalah**: Blocking parser, tidak ada defer/async
  - **Dampak**: Menunda Time to Interactive (TTI)

- **SweetAlert2 dari CDN** - Di `frontend.blade.php` line 261:
  ```html
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  ```
  - **Masalah**: Blocking parser, tidak critical untuk initial load
  - **Dampak**: Menunda TTI

### 3. **Large JavaScript Bundle**
- **Animate.css** - Di `app.js` line 11:
  ```js
  import 'animate.css';
  ```
  - **Masalah**: Library besar (sekitar 50KB) diimport secara penuh
  - **Dampak**: Meningkatkan bundle size dan waktu parsing JS

- **Alpine.js** - Di `app.js` line 3-7
  - **Masalah**: Tidak ada code splitting
  - **Dampak**: Semua JS dimuat sekaligus

### 4. **Image Optimization Issues**
- **Hero Images tanpa lazy loading** - Di `home.blade.php`:
  ```html
  <img src="{{ Storage::url($settings['hero_image_1']) }}" alt="Hero Slide 1">
  ```
  - **Masalah**: 
    - Tidak ada `loading="eager"` untuk LCP image (hero pertama)
    - Tidak ada `fetchpriority="high"` untuk LCP image
    - Tidak ada `width` dan `height` attributes
    - Tidak ada `srcset` untuk responsive images
    - Tidak ada format modern (WebP/AVIF)
  - **Dampak**: 
    - Layout shift (CLS)
    - Lambat LCP
    - Ukuran file besar

- **Background images tanpa optimization** - Di `home.blade.php`:
  ```html
  style="background-image: url('{{ Storage::url($settings['hero_slide_bg_1']) }}');"
  ```
  - **Masalah**: Tidak ada preload untuk critical background images
  - **Dampak**: Lambat LCP

### 5. **Large CSS File**
- **app.css** - 2400+ lines dengan banyak unused CSS
  - **Masalah**: 
    - Tidak ada purging untuk unused CSS
    - Banyak custom CSS yang mungkin tidak digunakan
    - Tidak ada code splitting untuk CSS
  - **Dampak**: Meningkatkan CSS parsing time

### 6. **Missing Resource Hints**
- **Tidak ada preconnect** untuk Google Fonts (meskipun ada untuk fonts.bunny.net)
- **Tidak ada preload** untuk critical resources (hero images, fonts)
- **Tidak ada dns-prefetch** untuk external domains

### 7. **Vite Configuration Not Optimized**
- **vite.config.js** - Tidak ada optimasi:
  ```js
  export default defineConfig({
    plugins: [laravel({...})],
  });
  ```
  - **Masalah**: 
    - Tidak ada code splitting
    - Tidak ada minification config
    - Tidak ada chunking strategy
  - **Dampak**: Bundle size besar, parsing time lama

### 8. **Third-Party Scripts Blocking**
- **AOS** - Library animasi yang besar, dimuat dari CDN
- **SweetAlert2** - Library alert yang besar, dimuat dari CDN
- **Masalah**: Tidak ada defer/async, blocking parser

### 9. **Font Loading Strategy**
- **Google Fonts** diimport via CSS @import
- **Masalah**: 
  - Render blocking
  - Tidak ada font-display: swap
  - Tidak ada preload untuk font files
  - FOIT (Flash of Invisible Text)

### 10. **No Critical CSS Inlining**
- **Masalah**: Semua CSS dimuat dari external file
- **Dampak**: Menunda FCP

## Solusi yang Direkomendasikan

### Priority 1: Critical (High Impact)

1. **Optimize Font Loading**
   - Pindahkan Google Fonts ke local atau gunakan font-display: swap
   - Preload font files
   - Gunakan preconnect untuk fonts.googleapis.com

2. **Optimize Images**
   - Tambahkan `loading="eager"` dan `fetchpriority="high"` untuk LCP image
   - Tambahkan `width` dan `height` attributes
   - Implement responsive images dengan `srcset`
   - Convert ke WebP/AVIF format
   - Preload critical hero images

3. **Defer Non-Critical JavaScript**
   - Tambahkan `defer` atau `async` untuk AOS dan SweetAlert2
   - Atau load secara lazy setelah page load

4. **Optimize Vite Build**
   - Enable code splitting
   - Configure chunking strategy
   - Enable minification

### Priority 2: Medium Impact

5. **Remove or Optimize AOS**
   - Consider removing AOS (sudah ada custom scroll animations)
   - Atau load AOS lazily

6. **Tree-shake Animate.css**
   - Import hanya animasi yang digunakan
   - Atau gunakan custom animations

7. **Optimize CSS**
   - Enable CSS purging
   - Split CSS per page
   - Inline critical CSS

8. **Add Resource Hints**
   - Preconnect untuk external domains
   - Preload critical resources
   - DNS-prefetch untuk third-party

### Priority 3: Low Impact (Nice to Have)

9. **Service Worker untuk Caching**
10. **Image CDN dengan auto-optimization**
11. **HTTP/2 Server Push untuk critical resources**

## Estimasi Peningkatan Skor

Dengan implementasi Priority 1 dan 2:
- **Current**: ~50
- **Expected**: ~75-85
- **Target**: 90+

## Next Steps

1. Implement optimizations secara bertahap
2. Test dengan Lighthouse setelah setiap perubahan
3. Monitor Core Web Vitals
4. A/B test untuk memastikan tidak ada regresi UX

