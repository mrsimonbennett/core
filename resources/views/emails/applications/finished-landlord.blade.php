@extends('emails.layout.master')
@section('content')
    <p>Hello {{$landlord->known_as}}</p>
    <p>{{$applicant->known_as}} has finished the application process for {{$property->address_firstline}} as is now
        available for your review.
    </p>
    <table>
        <tr>
            <td class="padding">
                <p><a href="https://{{$company->domain}}.fullrentcore.local/properties/{{$property->id}}"
                      class="btn-primary">View Application</a></p>
            </td>
        </tr>
    </table>

    <p>Thanks,<br/> The FullRent Team</p>

@stop