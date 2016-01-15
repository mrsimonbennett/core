{!!Form::Open(['url'=> '/manage-account/basic','method' => 'put','class' =>'form-horizontal'])!!}
<fieldset>
    @include('parts.error')

            <!-- Form Name -->
    <legend>Basic Information</legend>

    <!-- Text input-->
    <div class="form-group">
        <label class="col-sm-4 control-label" for="legal_name">Legal Name</label>

        <div class="col-sm-8">
            {!!Form::text('legal_name',$currentUser->legal_name,['class'=>
            'form-control'])!!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label" for="known_as">Known As </label>

        <div class="col-sm-8">

            {!!Form::text('known_as',$currentUser->known_as,['class'=>
                      'form-control'])!!}
            <p class="help-block">We will use this to communicate with you</p>
        </div>


    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <div class="pull-right">
                <button type="submit" class="btn btn-primary"><i
                            class="fa fa-save"></i>
                    Save
                </button>
            </div>
        </div>
    </div>
</fieldset>
{!! Form::close() !!}