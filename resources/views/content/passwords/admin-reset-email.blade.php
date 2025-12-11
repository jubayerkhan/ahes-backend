@component('mail::message')
# Hello Sir/Madam,

{!! "You are receiving this email because we received a password reset request for your account." !!}

{!! "You can change your password by clicking on the button below:" !!}

@component('mail::button', ['url' => $url])
Reset Password
@endcomponent

{!! "<strong>Best Regard,<br>".env('APP_NAME')."</strong>" !!}

@slot('subcopy')
If you have trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser. <br>
<a href="{{ $url }}">{{ $url }}</a>
@endslot

@endcomponent
