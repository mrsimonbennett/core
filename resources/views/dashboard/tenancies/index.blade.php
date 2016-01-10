@extends('dashboard.layout.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content p-l">
                <h2>Your Tenancies</h2>

                <p><a href="/tenancies/draft" class="btn btn-primary btn-xs">Draft New Tenancy</a>

                </p>
                <table class="table table-striped">

                    <tbody>
                    @foreach($tenancies as $tenancy)
                        <tr>
                            <td>
                                <img src="http://placehold.it/200x100" alt="">
                            </td>
                            <td style="vertical-align:middle">
                                {{$tenancy->property->address_firstline}} - {{$tenancy->property->address_postcode}}</td>
                            <td style="vertical-align:middle">
                                {{(new \Carbon\Carbon($tenancy->tenancy_start))->toFormattedDateString()}}</td>
                            <td style="vertical-align:middle">
                                {{(new \Carbon\Carbon($tenancy->tenancy_end))->toFormattedDateString()}}</td>
                            <td style="vertical-align:middle">
                                £{{$tenancy->tenancy_rent_amount}}</td>
                            <td style="vertical-align:middle">
                                {{$tenancy->tenancy_rent_frequency_formatted}}</td>
                            <td style="vertical-align:middle">
                                <a href="/tenancies/{{$tenancy->id}}" class="btn btn-primary btn-xs">View/Edit</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
