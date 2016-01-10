@extends('auth.layout.master')
@section('content')
    <h3>Forgotten your password?</h3>

    <p>Enter your new password for your FullRent account.
    </p>
    @include('parts.error')
    {!!Form::Open(['url'=> "/auth/password-reset/{$token}",'method' => 'post','class' => 'm-t'])!!}
    <div class="form-group">
        {!!Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Current Email'])!!}
    </div>
    <div class="form-group">
        {!!Form::password('password', ['class' => 'form-control', 'placeholder' => 'New Password'])!!}
    </div>
    <div class="form-group">
        {!!Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm New Password'])!!}
    </div>
    <button type="submit" class="btn btn-primary block full-width m-b">Change my password</button>

    <a href="/auth/login">
        <small>Return to login</small>
    </a>
    </form>

@stop