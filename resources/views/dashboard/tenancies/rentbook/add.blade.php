@extends('dashboard.layout.master')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="wrapper wrapper-content animated fadeInRight ibox">

                {!!Form::open(['url' => "/tenancies/". $tenancyId . '/rentbook' , 'method' => 'POST','class' => 'form-horizontal'])!!}
                <div class="ibox-title">
                    <legend>Schedule Rent Payment to Rent Book</legend>
                </div>
                <div class="ibox-content p-xl">
                    <fieldset>

                        @include('parts.error')


                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="textinput">Rent Due</label>
                            <div class="col-sm-8">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    {!!Form::text('rent_due',Carbon\Carbon::now()->startOfMonth()->format('d/m/Y'),['class'=>'form-control datepicker'])!!}
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="rent">Rent Amount</label>

                            <div class="col-sm-8">
                                <div class="input-group date">
                                    <span class="input-group-addon">&pound;</span>
                                    {!!Form::text('rent_amount',null,['class'=>'form-control'])!!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        Add Rent Book Payment <i class="fa fa-save"></i>
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
