@extends('emails.layout.master')
@section('content')
    <p>
        Hello {{$name}},
    </p>
    <p>
       Thank you for joining FullRent, if you need any help and support please feel to contact us, by replying to this email
    </p>
    <p>You can now login to your account</p>

    <table>
        <tr>
            <td class="padding">
                <p><a href="https://{{$company->domain}}.{{config('app.client_domain')}}"
                      class="btn-primary">Login</a></p>

                <p class="small">Need the raw link? <br> https://{{$company->domain}}.{{config('app.client_domain')}}</p>
            </td>
        </tr>
    </table>
    <p>Thanks you,<br/> The FullRent Team</p>

@stop