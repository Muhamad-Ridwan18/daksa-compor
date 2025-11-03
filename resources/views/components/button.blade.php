@props(['variant' => 'primary', 'type' => 'button', 'size' => 'md', 'href' => null, 'icon' => null, 'iconRight' => false])

@php
    $component = new \App\View\Components\Button($variant, $type, $size, $href, $icon, $iconRight);
    $classes = $component->getClasses();
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon && !$iconRight)
            <span class="mr-2">{!! $icon !!}</span>
        @endif
        
        {{ $slot }}
        
        @if($icon && $iconRight)
            <span class="ml-2">{!! $icon !!}</span>
        @endif
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon && !$iconRight)
            <span class="mr-2">{!! $icon !!}</span>
        @endif
        
        {{ $slot }}
        
        @if($icon && $iconRight)
            <span class="ml-2">{!! $icon !!}</span>
        @endif
    </button>
@endif

