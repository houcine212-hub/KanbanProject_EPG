@php
    $percentage = $percentage ?? 0;
@endphp
<span style="font-size:0.75rem;color:var(--text3)">{{ $percentage }}%</span>
<div class="progress-bar-wrap">
    <div class="progress-bar" style="width: {{ $percentage }}%"></div>
</div>