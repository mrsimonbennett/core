@can('manage_tenancy',$tenancy->id)
<p>Don't worry tenants will not be able to see any sensitive information
    about the tenancy.
    <br>


</p>
<p>
    <a href="/tenancies/{{$tenancy->id}}/invite" class="btn btn-primary btn-xs"> Invite Tenant <i
                class="fa fa-user"></i></a>
</p>

<p>
    Below are the current tenants on this tenancy, they will not be able to see any details until you publish the tenancy
</p>
@endcan
<table class="table table-striped table-hover">
    <tbody>
    @foreach($tenancy->tenants as $tenant)
        <tr>
            <td>{{$tenant->known_as}}</td>
            <td>{{$tenant->email}}</td>
        </tr>
    @endforeach

    </tbody>
</table>
