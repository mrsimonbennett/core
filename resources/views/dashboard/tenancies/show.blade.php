@extends('dashboard.layout.master')

@section('content')
    <style>
        .ibox-nav > li.active > a, .ibox-nav > li.active > a:hover, .ibox-nav > li.active > a:focus {
        }

        .ibox-nav > li > a {
            padding-left: 20px;
            padding-top: 15px;
            border-radius: 0px;
        }
    </style>
    <div class="row">

        <div class="col-lg-12">
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-9">
                    <h2>
                        @can('manage_tenancy',$tenancy->id)
                        <span class="label label-warning">Draft</span>
                        @endcan
                        Tenancy
                        for {{$tenancy->property->address_firstline}}
                        <small> - {{(new \Carbon\Carbon($tenancy->tenancy_start))->toFormattedDateString()}}
                            - {{(new \Carbon\Carbon($tenancy->tenancy_end))->toFormattedDateString()}}</small>
                    </h2>

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title ">
                                <h5>
                                    Todo to complete tenancy
                                </h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>

                                </div>
                            </div>
                            <div class="ibox-content">
                                <ul>
                                    <li>
                                        <a data-toggle="tab" href="#payments">Arrange Payments</a>
                                    </li>
                                    <li>
                                        Invite Tenant
                                    </li>
                                    <li>
                                        Upload Tenancy Agreement/Legal Documents
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>


                    <div class="col-lg-9">
                        <div class="panel blank-panel">

                            <div class="ibox float-e-margins">

                                <div class="ibox-title no-padding">

                                    <ul class="nav nav-tabs ibox-nav">
                                        <li class="active"><a data-toggle="tab" href="#overview">Overview</a></li>
                                        <li class=""><a data-toggle="tab" href="#rentbook">Rent Book</a></li>
                                        <li class=""><a data-toggle="tab" href="#tenants">Tenants</a></li>
                                        <li class=""><a data-toggle="tab" href="#photos">Legal Documents</a></li>
                                    </ul>
                                </div>
                                <div class="ibox-content">
                                    <div class="panel-heading">
                                        <div class="panel-options">


                                        </div>
                                    </div>


                                    <div class="panel-body">

                                        <div class="tab-content">
                                            <div id="overview" class="tab-pane active">
                                                OverView
                                            </div>
                                            <div id="rentbook" class="tab-pane">
                                                @include('dashboard.tenancies.parts.rentbook')
                                            </div>
                                            <div id="tenants" class="tab-pane">
                                                @include('dashboard.tenancies.parts.tenants')
                                            </div>
                                            <div id="photos" class="tab-pane">
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /.col-lg-12 -->
            <!-- /.row -->
        </div>
    </div>
    </div>
    </div>

    </div>
@stop
@section('scripts')
    <script>
        $(function () {

        })
    </script>

@stop