@props(['type' => 'submit'])

<button
    {{ $attributes->merge([
        'type' => $type,
        'class' => '
            inline-flex items-center justify-center
            rounded-xl
            bg-gradient-to-r from-blue-700 to-indigo-700
            px-6 py-3
            text-sm font-semibold text-white
            shadow-lg
            hover:from-blue-800 hover:to-indigo-800
            focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
            transition-all duration-200
        '
    ]) }}
>
    {{ $slot }}
</button>
