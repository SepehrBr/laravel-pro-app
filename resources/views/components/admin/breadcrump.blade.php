@props([
    'active' => false
])
<li class="breadcrumb-item {{ $active ? 'active' : '' }}">
    <a {{$attributes}} >{{ $slot }}</a>
</li>


{{--

<x-admin.header>
    title
    <x-slot:breadcrump>
        <x-admin.breadcrump href="{{ url('/admin')}}" >admin</x-admin.breadcrump>
        <x-admin.breadcrump :active="true">users</x-admin.breadcrump>
    </x-slot>
</x-header>

--}}
