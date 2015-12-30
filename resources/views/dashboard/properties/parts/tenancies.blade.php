<h2>Tenancies</h2>


<h4>Draft Tenancies</h4>

@if(count($tenancies))
    <table class="table table-striped">
        <thead>
        <tr>
            <th>From</th>
            <th>To</th>
            <th>Rent</th>
            <th>Rent Frequency</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>

        @foreach($tenancies as $tenancy)
            <tr>
                <td>{{(new \Carbon\Carbon($tenancy->tenancy_start))->toFormattedDateString()}}</td>
                <td>{{(new \Carbon\Carbon($tenancy->tenancy_end))->toFormattedDateString()}}</td>
                <td>£{{$tenancy->tenancy_rent_amount}}</td>
                <td>{{$tenancy->tenancy_rent_frequency_formatted}}</td>
                <td><a href="/tenancies/{{$tenancy->id}}" class="btn btn-primary btn-xs">View/Edit</a></td>
            </tr>

        @endforeach
        </tbody>

    </table>


    <a href="/properties/{{$property->id}}/draft-tenancy" class="btn btn-success btn-sm">Draft Tenancy <i
                class="fa fa-legal"></i></a>

@else
    <a href="/properties/{{$property->id}}/draft-tenancy" class="btn btn-success btn-sm">Draft First Tenancy <i
                class="fa fa-legal"></i></a>
@endif
