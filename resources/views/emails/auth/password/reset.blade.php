@extends('emails.layout.master')
@section('content')
    <p>Hello {{$user->known_as}}</p>
    <p>You told us you forgot your password. If you really did, click here to choose a new one:
    </p>
    <table>
        <tr>
            <td class="padding">
                <p><a href="https://{{$company->domain}}.{{env('CARDLESS_REDIRECT')}}/auth/password-reset/{{$token}}"
                      class="btn-primary">Choose a new password</a></p>

                <p class="small">Need the raw link? <br> https://{{$company->domain}}.{{env('CARDLESS_REDIRECT')}}/auth/password-reset/{{$token}}</p>
            </td>
        </tr>
    </table>
    <p>If you didn't mean to reset your password, then you can just ignore this email; your password will not change.§
    </p>
    <p>Thanks you,<br/> The FullRent Team</p>

@stop