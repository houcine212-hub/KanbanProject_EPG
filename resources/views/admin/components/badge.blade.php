@php
    $classes = [
        'blue' => 'badge-blue',
        'gray' => 'badge-gray',
    ];
    $badgeClass = $classes[$type] ?? 'badge-gray';
@endphp
<span class="badge {{ $badgeClass }}">{{ $text }}</span>