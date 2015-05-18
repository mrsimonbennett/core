@extends('emails.layout.master')
@section('content')
    <p>Hello {{$tenant->known_as}}</p>
    <p>{{$landlord->known_as}} has finished the contract for <em>{{$property->address_firstline}}</em> and is now
        available for your review, upload required documents and sign the tenancy agreement.
    </p>
    <table>
        <tr>
            <td class="padding">
                <p><a href="https://{{$company->domain}}.fullrentcore.local/tenancy/{{$contract->id}}"
                      class="btn-primary">View Contract</a></p>
            </td>
        </tr>
    </table>

    <p>Thanks you,<br/> The FullRent Team</p>

@stop