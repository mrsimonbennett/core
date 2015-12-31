<p>
    Below are our best guesses of your rent booked based on the tenancy
    setup
</p>
<p>
    @if(!$currentCompany->direct_debit_setup)
        <a href="#setup-directdebit" class="btn btn-primary btn-sm" data-toggle="modal">Set Up Direct Debit Rent
            Collection</a>
    @endif
</p>
<table class="table table-striped table-hover">
    <tbody>
    @foreach($tenancy->rent_book_payments as $payment)
        <tr>
            <td>{{(new \Carbon\Carbon($payment->payment_due))->toFormattedDateString()}}</td>
            <td> £{{$payment->payment_amount}}</td>
            <td class="client-status">
                <a href="/tenancies/{{$tenancy->id}}/rentbook/{{$payment->id}}/change"
                   class="btn btn-xs btn-success">
                    Change <i class="fa fa-pencil"></i>
                </a>
                <a href="/tenancies/{{$tenancy->id}}/rentbook/{{$payment->id}}/delete"
                   class="btn btn-xs btn-danger">
                    Delete <i class="fa fa-trash"></i>
                </a>
            </td>
        </tr>
    @endforeach
    <tr>
        <td>Total:</td>
        <td>£{{$rentTotal}}</td>
        <td><a href="/tenancies/{{$tenancy->id}}/rentbook/add"
               class="btn btn-xs btn-primary">Add <i
                        class="fa fa-plus"></i></a></td>
    </tr>
    </tbody>
</table>

<div id="setup-directdebit" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <h3 class="m-t-none m-b">Set Up Direct Debit</h3>

                    <p>
                        Direct debit will allow for a tenant to send rent payments directly to you from there bank
                        account.
                        We use a 3rd party system <a href="#">GoCardless</a> which acts as a gateway.
                    </p>
                    <p>
                        GoCardless charges a 1% fee which is capped at £2.00 per transaction, and FullRent charges £0.50
                        to provide all the reporting features (notifications of successful, failed and canceled direct
                        debits).
                    </p>
                    <p>
                        So all rent payments of £200 or more will be <strong>capped</strong> at a fee of £2.50.
                    </p>
                    @if($currentCompany->subscription_plan == 'trail')
                        <div class="alert alert-warning">
                            Due to the complex nature of direct debits and dealing with banks, we only offer this
                            feature to paying customers,
                            <a href="/company/settings/billing">please upgrade</a>
                        </div>
                    @else

                        {!!Form::open(['url' => "/company/settings/setup-direct-debit" , 'method' => 'POST','class' => 'form-horizontal'])!!}

                        <fieldset>
                            <div class="ibox-title">
                                <legend>Set Up Directly Debit</legend>
                            </div>
                            <div class="ibox-content p-xl">
                                @include('parts.error')

                                <div class="form-group">
                                    <label for="phone" class="col-sm-2 control-label">Phone</label>
                                    <div class="col-sm-10">
                                        {!!Form::text('phone',null,['class'=>'form-control'])!!}
                                    </div>
                                </div>
                                <hr>
                                <h5>Billing Address</h5>


                                <div class="form-group">
                                    <label for="phone" class="col-sm-2 control-label">Address</label>
                                    <div class="col-sm-10">
                                        {!!Form::text('address',null,['class'=>'form-control'])!!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="phone" class="col-sm-2 control-label">Town</label>
                                    <div class="col-sm-10">
                                        {!!Form::text('town',null,['class'=>'form-control'])!!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="col-sm-2 control-label">Postcode</label>
                                    <div class="col-sm-10">
                                        {!!Form::text('postcode',null,['class'=>'form-control'])!!}
                                    </div>
                                </div>
                                {!!Form::hidden('tenancy_id',$tenancy->id)!!}

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <p class="help-block">I agree to FullRent's Terms</p>
                                        <div class="pull-right">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                Set Up Direct Debit <i class="fa fa-external-link"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </fieldset>

                        {!! Form::close()!!}

                    @endif


                </div>
            </div>
        </div>
    </div>
</div>