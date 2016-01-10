@extends('dashboard.layout.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInRight ibox">
                {!!Form::Open(['url'=> '/properties','method' => 'post','class' =>
                                 'form-horizontal'])!!}
                <div class="ibox-title">
                    <legend>Add New Property</legend>


                </div>
                <div class="ibox-content p-xl">


                    <fieldset>

                        <!-- Form Name -->
                        @include('parts.error')

                                <!-- Text input-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput">Street Address</label>

                            <div class="col-sm-10">
                                {!!Form::text('address',null,['class'=>
                                'form-control','placeholder'=>'e.g. West Lodge'])!!}
                            </div>
                        </div>


                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput">City</label>

                            <div class="col-sm-10">
                                {!!Form::text('city',null,['class'=>'form-control','placeholder'=>'e.g. Norwich'])!!}
                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput">County</label>

                            <div class="col-sm-4">
                                {!!Form::text('county',null,['class'=>'form-control','placeholder'=>'e.g. Norfolk'])!!}
                            </div>

                            <label class="col-sm-2 control-label" for="textinput">Postcode</label>

                            <div class="col-sm-4">
                                {!!Form::text('postcode',null,['class'=>'form-control','placeholder'=>'e.g. NR14 7AN'])!!}
                            </div>
                        </div>


                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput">Country</label>

                            <div class="col-sm-10">
                                {!!Form::text('country','United Kingdom',['class'=>'form-control','placeholder'=>'Country'])!!}
                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput">Bedrooms</label>

                            <div class="col-sm-4">
                                {!!Form::select('bedrooms',$bedrooms,3,['class'=>'form-control']);!!}
                            </div>
                            <label class="col-sm-2 control-label" for="textinput">Bathrooms</label>

                            <div class="col-sm-4">
                                {!!Form::select('bathrooms',$bathrooms,1,['class'=>'form-control']);!!}
                            </div>
                        </div>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput">Parking</label>

                            <div class="col-sm-4">
                                {!!Form::select('parking',$bathrooms,1,['class'=>'form-control']);!!}
                            </div>
                            <label class="col-sm-2 control-label" for="textinput">Pets</label>

                            <div class="col-sm-4">
                                {!!Form::select('pets',['no' => 'No', 'yes' => 'Yes', 'permission'
                                =>
                                'Only with Permission'],'permission',['class'=>'form-control']);!!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        Add New Property <i
                                                class="fa fa-save"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </fieldset>
                    </form>

                </div>
            </div>
        </div>
    </div>

@stop