@extends('dashboard.layout.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content p-xl">

                <h1>User Settings
                    @if ($userId !== Auth::user()->getAuthIdentifier())
                        for {{{Auth::user()->known_as}}}
                    @endif
                </h1>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="ibox-content p-xl">
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="/manage-account">Basic Information</a></li>
                                <li><a href="/manage-account/email">Email</a></li>
                                <li><a href="/manage-account/password">Password</a></li>


                            </ul>

                        </div>


                    </div>
                    <div class="col-lg-8">
                        <div class="ibox-content p-xl">
                            @include('dashboard.manage-account.forms.' . $settingsType)

                        </div>
                    </div>

                </div>
            </div>
            <!-- /.col-lg-12 -->
            <!-- /.row -->
        </div>
    </div>


@stop
