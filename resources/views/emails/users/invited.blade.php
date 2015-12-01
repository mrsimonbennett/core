@extends('emails.layout.master')
@section('content')
    <p>
        You have been invited to FullRent, for the tenancy
        at {{$tenancy->property->address_firstline}} {{$tenancy->property->address_postcode}}.
    </p>
    <p>
        Your landlord has chosen to use FullRent for managing the tenancy with you. This offers many benefits:
    <ul>
        <li>Easier Communications</li>
        <li>Ability to set up and control Direct Debit online, for rent payments.</li>
        <li>Synced Calenders</li>
        <li>Fast Notifications</li>
        <li>Online Documentation viewing (Gas Cert</li>
        <li>Issue tracking (repair work etc)</li>
    </ul>
    </p>
    <table>
        <tr>
            <td class="padding">
                <p><a href="https://{{$company->domain}}.{{config('app.client_domain')}}/auth/invited/{{$token}}"
                      class="btn-primary">Create Account</a></p>

                <p class="small">Need the raw link? <br> https://{{$company->domain}}.{{config('app.client_domain')}}
                    /auth/invited/{{$token}}</p>
            </td>
        </tr>
    </table>
    <p>Thanks you,<br/> The FullRent Team</p>

@stop