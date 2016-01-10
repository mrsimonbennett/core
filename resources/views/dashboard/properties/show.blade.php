@extends('dashboard.layout.master')

@section('content')
    <style>
        .ibox-nav > li.active > a, .ibox-nav > li.active > a:hover, .ibox-nav > li.active > a:focus
        {
        }
        .ibox-nav > li > a
        {
            padding-left: 20px;
            padding-top: 15px;
            border-radius: 0px;
        }
    </style>
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title ">
                                <h5>{{$property->address_firstline}}
                                    <small>{{$property->address_postcode}}</small>
                                </h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>

                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="ibox-content no-padding border-left-right">
                                    <img src="http://placehold.it/600x200" alt="" class="img-responsive">
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <ul>
                                            <li>{{$property->address_firstline}}</li>
                                            <li>{{$property->address_city}}</li>
                                            <li>{{$property->address_county}}</li>
                                            <li>{{$property->address_postcode}}</li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-6">
                                        <ul>
                                            <li>{{$property->pets}}</li>
                                            <li>{{$property->bedrooms}} Bedrooms</li>
                                            <li>{{$property->bathrooms}} Bathrooms</li>
                                            <li>{{$property->parking}} Parking Spots</li>
                                        </ul>
                                    </div>
                                </div>
                                <a href="/properties/{{$property->id}}/edit" class="btn btn-primary center-block btn-sm">Update Property</a>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-8">
                        <div class="panel blank-panel">

                            <div class="ibox float-e-margins">

                                <div class="ibox-title no-padding">

                                    <ul class="nav nav-tabs ibox-nav">
                                        <li class="active"><a data-toggle="tab" href="#overview">Overview</a></li>
                                        <li class=""><a data-toggle="tab" href="#tenancies">Tenancies</a></li>
                                        <li class=""><a data-toggle="tab" href="#activitylog">Activity Log</a></li>
                                        <li class=""><a data-toggle="tab" href="#photos">Photos</a></li>
                                        <li class=""><a data-toggle="tab" href="#activitylog">Current Tenants</a></li>
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
                                                Property Overview
                                            </div>
                                            <div id="tenancies" class="tab-pane">
                                                @include('dashboard.properties.parts.tenancies')

                                            </div>
                                            <div id="activitylog" class="tab-pane">
                                               @include('dashboard.properties.parts.events')
                                            </div>
                                            <div id="photos" class="tab-pane">
                                                @include('dashboard.properties.parts.photos')
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
            var elem = document.querySelector('.js-switcher');
            var switchery = new Switchery(elem, {size: 'small', color: '#1AB394'});


            elem.onchange = function () {
                if (elem.checked) {
                    //send open
                    $('#accepting-applications').slideDown();
                    $.ajax({
                        url: window.location.pathname + '/accept-applications',
                        type: "post",
                        dataType: "json"
                    })
                }
                else {
                    //sent closed
                    $('#accepting-applications').slideUp();
                    $.ajax({
                        url: window.location.pathname + '/close-applications',
                        type: "post",
                        dataType: "json"
                    })
                }
            };

            $('#email-application').click(function () {
                console.log($(this).data('application'))
                $('#modal-form').modal('show')
            })
            $('#application-email-form').submit(function (e) {
                e.preventDefault();

                $.ajax({
                    url: window.location.pathname + '/email-applications',
                    dataType: 'json',
                    method: 'POST',
                    data: {email: $("#application-email").val()}
                }).success(function (response) {
                    $('#modal-form').modal('hide')

                });
                return false;
            })
        })
    </script>
@stop