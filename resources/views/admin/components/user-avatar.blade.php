@php
    $size = $size ?? 34;
    $fontSize = $fontSize ?? '0.68rem';
    $hue = (ord($user->name[0]) * 47) % 360;
    $bg1 = "hsl({$hue},60%,45%)";
    $bg2 = "hsl(" . (($hue + 40) % 360) . ",55%,40%)";
@endphp
<div class="user-ava" style="width:{{ $size }}px;height:{{ $size }}px;font-size:{{ $fontSize }};background:linear-gradient(135deg,{{ $bg1 }},{{ $bg2 }})">
    @if($user->avatar)
        <img src="{{ asset('storage/' . $user->avatar) }}" alt="">
    @else
        {{ strtoupper(substr($user->name, 0, 1)) }}
    @endif
</div>