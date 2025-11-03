<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public string $type;
    public string $variant;
    public string $size;
    public ?string $href;
    public ?string $icon;
    public bool $iconRight;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $variant = 'primary',
        string $type = 'button',
        string $size = 'md',
        ?string $href = null,
        ?string $icon = null,
        bool $iconRight = false
    ) {
        $this->variant = $variant;
        $this->type = $type;
        $this->size = $size;
        $this->href = $href;
        $this->icon = $icon;
        $this->iconRight = $iconRight;
    }

    /**
     * Get the button classes based on variant and size.
     */
    public function getClasses(): string
    {
        $baseClasses = 'inline-flex items-center justify-center font-semibold rounded-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2';
        
        // Size classes
        $sizeClasses = match($this->size) {
            'sm' => 'px-4 py-2 text-sm',
            'md' => 'px-6 py-3 text-base',
            'lg' => 'px-8 py-4 text-lg',
            default => 'px-6 py-3 text-base',
        };

        // Variant classes
        $variantClasses = match($this->variant) {
            'primary' => 'bg-blue-600 hover:bg-blue-700 text-white shadow-md hover:shadow-lg focus:ring-blue-500',
            'secondary' => 'bg-gray-600 hover:bg-gray-700 text-white shadow-md hover:shadow-lg focus:ring-gray-500',
            'success' => 'bg-green-600 hover:bg-green-700 text-white shadow-md hover:shadow-lg focus:ring-green-500',
            'danger' => 'bg-red-600 hover:bg-red-700 text-white shadow-md hover:shadow-lg focus:ring-red-500',
            'warning' => 'bg-yellow-500 hover:bg-yellow-600 text-white shadow-md hover:shadow-lg focus:ring-yellow-400',
            'info' => 'bg-cyan-600 hover:bg-cyan-700 text-white shadow-md hover:shadow-lg focus:ring-cyan-500',
            'outline-primary' => 'border-2 border-blue-600 text-blue-600 hover:bg-blue-50 focus:ring-blue-500',
            'outline-secondary' => 'border-2 border-gray-600 text-gray-600 hover:bg-gray-50 focus:ring-gray-500',
            'outline-danger' => 'border-2 border-red-600 text-red-600 hover:bg-red-50 focus:ring-red-500',
            'ghost' => 'text-gray-700 hover:bg-gray-100 focus:ring-gray-400',
            'link' => 'text-blue-600 hover:text-blue-700 hover:underline focus:ring-blue-500',
            default => 'bg-blue-600 hover:bg-blue-700 text-white shadow-md hover:shadow-lg focus:ring-blue-500',
        };

        return "$baseClasses $sizeClasses $variantClasses";
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.button');
    }
}

