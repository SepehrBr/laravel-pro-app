@component('mail::message')
Welcome {{ $user->name }}
@component('mail::button', ['url' => '/', 'color' => 'success'])
    validate email
@endcomponent
2024 laravel-pro-app
@endcomponent
