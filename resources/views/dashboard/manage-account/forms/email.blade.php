{!!Form::Open(['url'=> '/manage-account/email','method' => 'put','class' =>'form-horizontal'])!!}
<fieldset>
    @include('parts.error')

            <!-- Form Name -->
    <legend>Email Address</legend>

    <!-- Text input-->
    <div class="form-group">
        <label class="col-sm-4 control-label" for="email">Email</label>

        <div class="col-sm-8">
            {!!Form::text('email',$currentUser->email,['class'=>
            'form-control'])!!}
        </div>
    </div>

   {{-- <div class="form-group">
        <label class="col-sm-4 control-label" for="known_as">Current Password</label>

        <div class="col-sm-8">

            {!!Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password'])!!}

        </div>


    </div>
    --}}
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