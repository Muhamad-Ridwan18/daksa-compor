@extends('layouts.frontend')

@section('content')
<!-- About Section -->
<section class="bg-white relative overflow-hidden">
    
    <div class="text-center mb-16 bg-primary min-h-[300px] flex items-center justify-center w-full" style="min-height:300px;" data-aos="fade-up">
        <h1 class="text-4xl md:text-5xl font-bold text-white w-full">Tentang Kami</h1>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Page Title -->

        <!-- Visi dan Misi Section -->
        {{-- <div class="mb-20" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Visi dan Misi Kami</h2>
            <p class="text-lg text-gray-700 leading-relaxed mb-8">
                {{ $settings['company_description'] ?? 'Kami adalah perusahaan yang berkomitmen untuk memberikan solusi terbaik bagi klien kami dengan pengalaman bertahun-tahun di industri ini.' }}
            </p>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Misi Kami -->
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Misi Kami</h3>
                    <div class="space-y-4">
                        @php
                            $misi = $settings['company_mission'] ?? [];
                            if (is_string($misi)) {
                                $misi = explode("\n", $misi);
                            }
                            if (empty($misi)) {
                                $misi = [
                                    'Berkomitmen penuh, menghasilkan sumber daya manusia berkualitas tinggi dalam bekerja (pelatihan, implementasi, dan pelayanan setelah penjualan).',
                                    'Memberikan konsultasi berdasarkan pengalaman dan metode analisis dalam memecahkan permasalahan yang dihadapi klien. Pengoperasian program secara efektif dan efisien sesuai bidang usaha klien.'
                                ];
                            }
                        @endphp
                        @foreach($misi as $item)
                            @if(trim($item))
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 mt-1">
                                    <svg class="w-6 h-6 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <p class="text-gray-700 leading-relaxed">{{ trim($item) }}</p>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Visi Kami -->
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Visi Kami</h3>
                    <div class="space-y-4">
                        @php
                            $visi = $settings['company_vision'] ?? [];
                            if (is_string($visi)) {
                                $visi = explode("\n", $visi);
                            }
                            if (empty($visi)) {
                                $visi = [
                                    'Memberikan pelayanan dengan professionalisme, integritas, dan akuntabilitas tinggi juga hasil jangka panjang dalam jasa konsultasi.'
                                ];
                            }
                        @endphp
                        @foreach($visi as $item)
                            @if(trim($item))
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 mt-1">
                                    <svg class="w-6 h-6 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-700 leading-relaxed">{{ trim($item) }}</p>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- Visi dan Misi Section -->
        <div class="mb-20 mt-8 mb-6" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Visi dan Misi Kami</h2>
            <p class="text-lg text-gray-700 leading-relaxed mb-12 text-left">
                {{ $settings['vision_mission_intro'] ?? 'Kami merupakan pelopor Jasa Pelatihan Accurate Accounting Software pertama di Indonesia, yang secara resmi bekerja sama dengan pihak CPSSoft selaku pemilik Accurate Accounting Software.' }}
            </p>

            <div class="space-y-12">
                <!-- Misi Kami -->
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Misi Kami</h3>
                    <div class="space-y-4">
                        @php
                            $misi = $settings['company_mission'] ?? '';
                            if ($misi) {
                                $misiArray = explode("\n", $misi);
                                $misiArray = array_filter(array_map('trim', $misiArray));
                            } else {
                                $misiArray = [
                                    'Berkomitmen penuh, menghasilkan sumber daya manusia berkualitas tinggi dalam bekerja (pelatihan, implementasi, dan pelayanan setelah penjualan).',
                                    'Memberikan konsultasi berdasarkan pengalaman dan metode analisis dalam memecahkan permasalahan yang dihadapi klien. Pengoperasian program secara efektif dan efisien sesuai bidang usaha klien.'
                                ];
                            }
                        @endphp
                        @foreach($misiArray as $item)
                            @if(trim($item))
                            <p class="text-gray-700 leading-relaxed">
                                {{ trim($item) }}
                            </p>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Visi Kami -->
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 mt-6">Visi Kami</h3>
                    <p class="text-gray-700 leading-relaxed">
                        {{ $settings['company_vision'] ?? 'Memberikan pelayanan dengan professionalisme, integritas, dan akuntabilitas tinggi juga hasil jangka panjang dalam jasa konsultasi.' }}
                    </p>
                </div>
            </div>
        </div>

        
        <!-- About Content with Image -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16 items-center">
            <!-- Image Section -->
            <div class="relative" data-aos="fade-up" data-aos-delay="0">
                <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                    @if(isset($settings['about_image']) && $settings['about_image'])
                        <img src="{{ Storage::url($settings['about_image']) }}" alt="Tentang Kami" class="w-full h-[500px] object-cover">
                    @else
                        <!-- Placeholder Image -->
                        <div class="w-full h-[500px] bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center">
                            <div class="text-center">
                                <svg class="w-24 h-24 mx-auto text-primary/40 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <p class="text-gray-500 text-lg">Tim Kami</p>
                            </div>
                        </div>
                    @endif
                    <!-- Decorative Elements -->
                    <div class="absolute -top-4 -right-4 w-24 h-24 bg-primary/20 rounded-full blur-2xl"></div>
                    <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-secondary/20 rounded-full blur-2xl"></div>
                </div>
            </div>
            
            <!-- Content Section -->
            <div class="lg:pl-8" data-aos="fade-up" data-aos-delay="100">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    {{ $settings['about_title'] ?? 'Mengapa Memilih Kami?' }}
                </h2>
                <div class="prose prose-lg text-gray-600 mb-8">
                    <p class="leading-relaxed text-justify">
                        {{ $settings['about_content'] ?? 'Dengan pengalaman lebih dari 10 tahun di industri, kami telah membantu ratusan klien mencapai tujuan bisnis mereka. Tim profesional kami berkomitmen untuk memberikan solusi terbaik yang disesuaikan dengan kebutuhan unik setiap klien.' }}
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mt-16 mb-8">
            <div class="text-center feature-card" data-aos="fade-up" data-aos-delay="0">
                <div class="bg-primary text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h4 class="text-xl font-semibold mb-2">Berpengalaman & Teruji</h4>
                <p class="text-gray-600">Menghadapi berbagai kasus dan sektor industri sejak 2016</p>
            </div>
            <div class="text-center feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-primary text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h4 class="text-xl font-semibold mb-2">Legalitas Terjamin</h4>
                <p class="text-gray-600">Memberikan Keamanan dan kepastian hukum dalam setiap layanan</p>
            </div>
            <div class="text-center feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="bg-primary text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                    </svg>
                </div>
                <h4 class="text-xl font-semibold mb-2">Solusi Terbaik untuk Bisnis Anda</h4>
                <p class="text-gray-600">Pendekatan yang disesuaikan dengan karakter dan kebutuhan perusahaan</p>
            </div>
            <div class="text-center feature-card" data-aos="fade-up" data-aos-delay="300">
                <div class="bg-primary text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h4 class="text-xl font-semibold mb-2">Responsif & Profesional</h4>
                <p class="text-gray-600">Pelayanan cepat dan profesional untuk kepuasan klien</p>
            </div>
        </div>
    </div>
</section>

<!-- Our Team Section -->
@if(isset($teamMembers) && $teamMembers->count() > 0)
<section class="py-20 bg-background relative overflow-hidden">
    <div class="absolute inset-0 opacity-40">
        <div class="pattern-dots"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16 section-heading" data-aos="fade-up">
            <div class="section-eyebrow">People</div>
            <h2 class="section-title">Tim Kami</h2>
            <div class="section-underline"></div>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto mt-4">
                Berkenalan dengan profesional di balik layanan kami.
            </p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($teamMembers as $memberIndex => $member)
            <div class="bg-white rounded-2xl shadow overflow-hidden" data-aos="fade-up" data-aos-delay="{{ $memberIndex * 100 }}">
                <div class="h-56 bg-gray-100 relative">
                    @if($member->photo)
                        <img src="{{ Storage::url($member->photo) }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $member->name }}</h3>
                    <p class="text-primary font-medium">{{ $member->role }}</p>
                    @if($member->bio)
                    <p class="text-gray-600 text-sm mt-3">{{ Str::limit($member->bio, 120) }}</p>
                    @endif
                    <div class="flex items-center justify-center gap-3 mt-4">
                        @if($member->linkedin)
                        <a href="{{ $member->linkedin }}" 
                           target="_blank" 
                           rel="noopener" 
                           class="text-gray-500 hover:text-primary min-w-[44px] min-h-[44px] flex items-center justify-center transition-colors"
                           aria-label="LinkedIn {{ $member->name }}">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.763 0 5-2.239 5-5v-14c0-2.761-2.237-5-5-5zm-11 19h-3v-10h3v10zm-1.5-11.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 11.268h-3v-5.604c0-1.336-.027-3.055-1.861-3.055-1.861 0-2.146 1.452-2.146 2.954v5.705h-3v-10h2.881v1.367h.041c.401-.759 1.379-1.559 2.838-1.559 3.037 0 3.6 2.001 3.6 4.604v5.588z"/></svg>
                        </a>
                        @endif
                        @if($member->twitter)
                        <a href="{{ $member->twitter }}" 
                           target="_blank" 
                           rel="noopener" 
                           class="text-gray-500 hover:text-primary min-w-[44px] min-h-[44px] flex items-center justify-center transition-colors"
                           aria-label="Twitter {{ $member->name }}">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                        @endif
                        @if($member->email)
                        <a href="mailto:{{ $member->email }}" 
                           class="text-gray-500 hover:text-primary min-w-[44px] min-h-[44px] flex items-center justify-center transition-colors"
                           aria-label="Email {{ $member->name }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Location Section -->
@if(($settings['gmaps_embed_url'] ?? null) || (($settings['gmaps_latitude'] ?? null) && ($settings['gmaps_longitude'] ?? null)) || ($settings['company_address'] ?? null))
<section class="py-20 bg-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16 section-heading" data-aos="fade-up">
            <div class="section-eyebrow">Lokasi</div>
            <h2 class="section-title" style="color: {{ $settings['primary_color'] ?? '#D89B30' }};">Lokasi Kami</h2>
            <div class="section-underline"></div>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto mt-4">
                Kunjungi kantor kami atau hubungi kami untuk konsultasi.
            </p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Address Info -->
            <div data-aos="fade-up" data-aos-delay="0">
                <h3 class="text-2xl font-semibold text-gray-900 mb-6">Alamat</h3>
                <div class="space-y-4">
                    @if($settings['company_address'] ?? null)
                    <div class="flex items-start">
                        <div class="bg-primary/10 p-3 rounded-full mr-4 flex-shrink-0">
                            <svg class="w-6 h-6 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-700 leading-relaxed">{{ $settings['company_address'] }}</p>
                        </div>
                    </div>
                    @endif
                    
                    @if($settings['company_phone'] ?? null)
                    <div class="flex items-start">
                        <div class="bg-primary/10 p-3 rounded-full mr-4 flex-shrink-0">
                            <svg class="w-6 h-6 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                        </div>
                        <div>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $settings['company_phone']) }}" class="text-gray-700 hover:text-primary transition-colors">
                                {{ $settings['company_phone'] }}
                            </a>
                        </div>
                    </div>
                    @endif
                    
                    @if($settings['company_email'] ?? null)
                    <div class="flex items-start">
                        <div class="bg-primary/10 p-3 rounded-full mr-4 flex-shrink-0">
                            <svg class="w-6 h-6 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                        </div>
                        <div>
                            <a href="mailto:{{ $settings['company_email'] }}" class="text-gray-700 hover:text-primary transition-colors">
                                {{ $settings['company_email'] }}
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Map -->
            <div data-aos="fade-up" data-aos-delay="100">
                <div class="rounded-xl overflow-hidden border border-gray-200 shadow-lg h-[400px]">
                    @php
                        $lat = $settings['gmaps_latitude'] ?? null;
                        $lng = $settings['gmaps_longitude'] ?? null;
                        $zoom = $settings['gmaps_zoom'] ?? 15;
                        $src = $settings['gmaps_embed_url'] ?? null;
                        if (!$src && $lat && $lng) {
                            $src = 'https://www.google.com/maps?q=' . $lat . ',' . $lng . '&z=' . $zoom . '&output=embed';
                        }
                    @endphp
                    @if($src)
                        <iframe 
                            src="{{ $src }}" 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Lokasi {{ $settings['company_name'] ?? 'Kantor Kami' }}">
                        </iframe>
                    @elseif($settings['company_address'] ?? null)
                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                            <div class="text-center p-6">
                                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <p class="text-gray-600">{{ $settings['company_address'] }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Contact Section -->
<section class="py-20 bg-secondary text-white relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0">
        <div class="contact-bg-shape shape-1"></div>
        <div class="contact-bg-shape shape-2"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16 section-heading" data-aos="fade-up">
            <div class="section-eyebrow">Kontak</div>
            <h2 class="section-title" style="color: white;hom">Hubungi Kami</h2>
            <div class="section-underline"></div>
            <p class="text-xl max-w-3xl mx-auto mt-4">
                Siap membantu mewujudkan impian bisnis Anda. Hubungi kami sekarang!
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div data-aos="fade-up" data-aos-delay="0">
                <h2 class="text-2xl font-semibold mb-6">Informasi Kontak</h2>
                <div class="space-y-4">
                    @if($settings['company_email'] ?? null)
                    <div class="flex items-center contact-info-item">
                        <div class="bg-primary/20 p-3 rounded-full mr-4">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                        </div>
                        <a href="mailto:{{ $settings['company_email'] }}" class="hover:text-primary transition-colors">
                            {{ $settings['company_email'] }}
                        </a>
                    </div>
                    @endif
                    
                    @if($settings['company_phone'] ?? null)
                    <div class="flex items-center contact-info-item">
                        <div class="bg-primary/20 p-3 rounded-full mr-4">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                        </div>
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $settings['company_phone']) }}" class="hover:text-primary transition-colors">
                            {{ $settings['company_phone'] }}
                        </a>
                    </div>
                    @endif
                    
                    @if($settings['company_address'] ?? null)
                    <div class="flex items-center contact-info-item">
                        <div class="bg-primary/20 p-3 rounded-full mr-4">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <span>{{ $settings['company_address'] }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <div data-aos="fade-up" data-aos-delay="100">
                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium mb-2">Nama</label>
                        <input type="text" id="name" name="name" required class="w-full px-4 py-3 text-gray-900 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium mb-2">Email</label>
                        <input type="email" id="email" name="email" required class="w-full px-4 py-3 text-gray-900 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium mb-2">Pesan</label>
                        <textarea id="message" name="message" rows="4" required class="w-full px-4 py-3 text-gray-900 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none"></textarea>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" class="px-4 py-2 text-sm bg-primary text-white font-semibold rounded-lg hover:bg-opacity-90 shadow flex-1 transition-colors">
                            Kirim Pesan
                        </button>
                        @php
                            $waNumber = preg_replace('/[^0-9]/', '', $settings['whatsapp_number'] ?? '') ?: null;
                            $waText = trim($settings['whatsapp_template'] ?? '');
                            $waUrl = $waNumber ? ('https://wa.me/' . $waNumber . ($waText !== '' ? ('?text=' . urlencode($waText)) : '')) : '#';
                        @endphp
                        @if($waNumber)
                        <a href="{{ $waUrl }}"
                            class="px-4 py-2 text-sm bg-green-500 text-white font-semibold hover:bg-green-600 rounded-lg shadow flex-1 flex items-center justify-center transition-colors"
                            target="_blank" rel="noopener"
                            style="background-color: #25D366;">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="white" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <span>WhatsApp</span>
                        </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

