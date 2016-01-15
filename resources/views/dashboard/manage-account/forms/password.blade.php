{!!Form::Open(['url'=> '/manage-account/password','method' => 'put','class' =>'form-horizontal'])!!}
<fieldset>
    @include('parts.error')

            <!-- Form Name -->
    <legend>Password</legend>

    <!-- Text input-->
    <div class="form-group">
        <label class="col-sm-4 control-label" for="email">Current Password</label>

        <div class="col-sm-8">
            {!!Form::password('old_password',['class'=> 'form-control'])!!}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label" for="email">New Password</label>

        <div class="col-sm-8">
            {!!Form::password('new_password',['class'=> 'form-control'])!!}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label" for="email">New Password Again</label>

        <div class="col-sm-8">
            {!!Form::password('new_password_confirmation',['class'=> 'form-control'])!!}
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