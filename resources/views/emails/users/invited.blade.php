@extends('emails.layout.master')
@section('content')
    <p>Hello </p>
    <p>You have been invited to fullrent
    </p>
    <table>
        <tr>
            <td class="padding">
                <p><a href="https://{{$company->domain}}.{{config('app.client_domain')}}/auth/invited/{{$token}}"
                      class="btn-primary">Complete Application</a></p>

                <p class="small">Need the raw link? <br> https://{{$company->domain}}.{{config('app.client_domain')}}/auth/invited/{{$token}}</p>
            </td>
        </tr>
    </table>
    <p>Thanks you,<br/> The FullRent Team</p>

@stop