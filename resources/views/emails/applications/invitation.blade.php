@extends('emails.layout.master')
@section('content')
    <p>Hello </p>
    <p>{{$landlord->known_as}} has has invited you to fill in a application for <strong>{{$property->address_firstline}} - {{$property->address_postcode}}</strong>.
    </p>
    <table>
        <tr>
            <td class="padding">
                <p><a href="https://{{$company->domain}}.fullrentcore.local/a/{{$property->id}}"
                      class="btn-primary">Click to Apply to {{$property->address_firstline}}</a></p>
                <p class="small">(If the button does not work copy and paste <br> https://{{$company->domain}}.fullrentcore.local/a/{{$property->id}} into your browser)</p>
            </td>
        </tr>
    </table>

    <p>Thanks,<br/> The FullRent Team</p>

@stop