<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#D89B30] border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-[#C88A20] focus:bg-[#C88A20] active:bg-[#B87A10] focus:outline-none focus:ring-2 focus:ring-[#D89B30] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
