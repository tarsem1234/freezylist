@component('mail::message')
# Availability Confirmation

<br>
Hello, <br>
Following user has confirmed to schedule a viewing of your property. Kindly check the details below and reply to the user. 
<p>
    <strong>Name: </strong> {{$user->full_name}} <br>
    <strong>Date: </strong> {{$availability->date}} <br>
    <strong>Time: </strong>{{$availability->start_time}} - {{$availability->end_time}}
</p>
@component('mail::button', ['url' => "mailto:".$user->email])
Reply
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent