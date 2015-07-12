@extends('emails.layout.master')
@section('content')
    <p>Hello {{$user->known_as}}</p>
    <p>We are just messaging you to tell you your Fullrent account password has been reset.

    </p>

    <p>If you did not perform this action yourself please email support@fullrent.co.uk and we will look into it
    </p>
    <p>Thanks you,<br/> The FullRent Team</p>

@stop