@extends('auth.layout.master')
@section('content')
    <h3>Login to demo.fullrent.co.uk</h3>

    <p>Enter your <strong> email address</strong> and <strong>password.</strong>

    </p>
    @include('parts.error')

    {!!Form::Open(['url'=> '/auth/login','method' => 'post','class' => 'm-t'])!!}
    <div class="form-group">
        {!!Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Email'])!!}
    </div>
    <div class="form-group">
        {!!Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password'])!!}
    </div>
    <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

    <a href="#">
        <small>Forgot password?</small>
    </a>

    {!! Form::close() !!}

@stop