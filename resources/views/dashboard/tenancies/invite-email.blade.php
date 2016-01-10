@extends('dashboard.layout.master')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="wrapper wrapper-content animated fadeInRight ibox">

                {!!Form::open(['url' => "/tenancies/". $tenancyId . "/invite-email", 'method' => 'POST','class' => 'form-horizontal'])!!}
                <div class="ibox-title">
                    <legend>Invite Tenant</legend>
                </div>
                <div class="ibox-content p-xl">
                    <fieldset>

                        @include('parts.error')
                        <p>We will email the tenant and invite them to FullRent. They will be give a tenants account
                            which allows them to see basic information about the tenancy,<br> they <strong>will
                                not</strong> be able to see private/sensitive data about you or the tenancy</p>
                        <p>
                            Benefits
                        <ul>
                            <li>Tenants can setup online rent payments (if setup)</li>
                            <li>Tenants can raise issues using FullRent making support easier</li>
                            <li>Tenants can receive notifications you send. (e.g. property inspections)</li>
                            <li>Tenants can view copies of paperwork you make available (e.g. DPS, Gas Certificate)</li>

                        </ul>
                        </p>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="rent">Tenant Email Address</label>

                            <div class="col-sm-8">
                                <div class="input-group date">
                                    <span class="input-group-addon">@</span>
                                    {!!Form::text('email',null,['class'=>'form-control'])!!}
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        Invite Tenant <i
                                                class="fa fa-user"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        </form>
                    </fieldset>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
    </div>
    </div>
    </div>

    </div>


@stop
