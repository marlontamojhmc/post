@component('mail::message')
# Hello {{ $user->name }}

Click the button below to securely login to SezadRIS.

@component('mail::button', ['url' => $loginUrl])
Login to SezadRIS
@endcomponent

This link expires in 30 minutes.

Thanks,<br>
SezadRIS Team
@endcomponent