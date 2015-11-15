@extends('emails.layout.master')
@section('content')
    <p>Hello {{$landlord->known_as}},</p>
    <p>
        Thank you for purchasing the <strong>Landlord Plan</strong> and becoming a paid customer, you will be billed £25 automatically on
        the <strong>{{(new \Carbon\Carbon($company->subscription_started_at))->format('jS')}}</strong> every month.
    </p>
    <p>
        If you have any comments on how we could improve the process just reply to this email your input is highly
        valued.
    </p>
    <table>
        <tr>
            <td class="padding">
                <p><a href="https://{{$company->domain}}.{{env('CARDLESS_REDIRECT')}}/company/settings/billing"
                      class="btn-primary">Review Billing</a></p>
                <p class="small">(If the button does not work copy and paste <br> https://{{$company->domain}}
                    .{{env('CARDLESS_REDIRECT')}}/company/settings/billing into your browser)</p>
            </td>
        </tr>
    </table>

    <p>Thanks,<br/> The FullRent Team</p>

@stop