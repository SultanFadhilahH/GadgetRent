@props(['name'])

@php
    $paths = [
        'home'    => 'M3 9.5 12 3l9 6.5V20a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1V9.5Z',
        'grid'    => 'M4 4h7v7H4V4Zm9 0h7v7h-7V4ZM4 13h7v7H4v-7Zm9 0h7v7h-7v-7Z',
        'device'  => 'M4 5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5Zm5 13h2m-5-3h8V5H6v10Z',
        'list'    => 'M4 6h16M4 12h16M4 18h10',
        'undo'    => 'M4 10h9a5 5 0 1 1 0 10h-2M4 10l4-4M4 10l4 4',
        'user'    => 'M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm-7 9a7 7 0 0 1 14 0',
        'users'   => 'M9 12a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm7-1a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM2.5 20a6.5 6.5 0 0 1 13 0M15 14.5a5.5 5.5 0 0 1 6.5 5.5',
        'report'  => 'M6 3.5h9l3 3V20a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V4.5a1 1 0 0 1 1-1Zm8 9v4m-4-6v6m8-3v3',
        'chart'   => 'M4 20V10m6 10V4m6 16v-7',
        'download' => 'M12 3v12m0 0-4-4m4 4 4-4M4 19h16',
    ];
    $d = $paths[$name] ?? $paths['grid'];
@endphp

<svg {{ $attributes->merge(['class' => 'h-5 w-5']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
    <path d="{{ $d }}" />
</svg>
