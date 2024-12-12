@props([
    'to' => $to,
    'active' => false
])
<li class="breadcrumb-item {{ $active ? 'active' : '' }}">
    <a href="{{ $to }}">{{ $slot }}</a>
</li>
