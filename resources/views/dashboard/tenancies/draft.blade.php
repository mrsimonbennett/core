@extends('dashboard.layout.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInRight ibox">

                {!!Form::open(['url' => "/tenancies" , 'method' => 'POST','class' => 'form-horizontal'])!!}
                <div class="ibox-title">
                    <legend>Draft Tenancy</legend>
                </div>
                <div class="ibox-content p-xl">
                    <fieldset>

                        @include('parts.error')

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput">Property</label>
                            <div class="col-sm-10">
                                {!!Form::select('tenancy_property_id',$properties,$currentPropertyId,['class'=>'form-control']);!!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput">Start</label>
                            <div class="col-sm-4">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    {!!Form::text('tenancy_start',Carbon\Carbon::now()->startOfMonth()->format('d/m/Y'),['class'=>'form-control datepicker'])!!}
                                </div>
                            </div>

                            <label class="col-sm-2 control-label" for="textinput">End</label>

                            <div class="col-sm-4">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    {!!Form::text('tenancy_end','',['class'=>'form-control datepicker'])!!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="rent">Rent</label>

                            <div class="col-sm-10">
                                <div class="input-group date">
                                    <span class="input-group-addon">&pound;</span>
                                    <div class="row">
                                        <div class="col-md-9">
                                            {!!Form::text('tenancy_rent_amount',null,['class'=>'form-control'])!!}
                                        </div>
                                        <div class="col-md-3">
                                            {!!Form::select('tenancy_rent_frequency',
                                            ['2-week' => 'Two Weekly',
                                            '4-week'=> 'Four Weekly',
                                            '1-month' => 'Monthly',
                                            '2-month' => '2 Months',
                                            '3-month' =>'3 Months',
                                            '4-month' =>'4 Months',
                                            '6-month' => '6 Months',
                                            '1-year' => 'Annually',
                                            'irregular' => 'Irregular Payments' ],'1-month',['class'=>'form-control'])!!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        Draft Tenancy <i
                                                class="fa fa-save"></i>
                                    </button>
                                </div>
                            </div>
                        </div>


                    </fieldset>
                    {!! Form::close()!!}
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
