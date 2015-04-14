@extends('emails.layout.master')
@section('content')
    <p>Hello {{$applicant->known_as}}</p>
    <p>{{$landlord->known_as}} has rejected your application for {{$property->address_firstline}} but your invited to resubmit
    </p>
    @if(!empty($reason))
       <p>{{$landlord->known_as}} left a comment to help you resubmit : {{$reason}}</p>
    @endif
    <table>
        <tr>
            <td class="padding">
                <p><a href="https://{{$company->domain}}.fullrentcore.local/a/{{$property->id}}"
                      class="btn-primary">Addend and Resubmit Application</a></p>
                <small>If you login</small>
            </td>
        </tr>
    </table>

    <p>Thanks,<br/> The FullRent Team</p>

@stop