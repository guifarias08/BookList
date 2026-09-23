@props(['status'])

@php
    $labels = [
        'want_to_read' => 'Quero ler',
        'reading' => 'Lendo',
        'read' => 'Concluído',
        'paused' => 'Pausado',
        'abandoned' => 'Abandonado',
    ];

    $label = $labels[$status] ?? ucfirst(str_replace('_', ' ', $status));
@endphp

<span {{ $attributes->class(['status-badge', 'status-' . $status]) }}>
    {{ $label }}
</span>