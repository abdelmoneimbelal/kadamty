@component('mail::message')
    # Introduction
    Kadmaty Reset Password.
    <p>Hello {{$user->name}}</p>

    <p>Your reset code is : {{$user->pin_code}}</p>


    Thanks,<br>
    {{ config('app.name') }}
@endcomponent