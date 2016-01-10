@extends('auth.layout.master')
@section('content')
        <h3>Forgotten your password?</h3>

        <p>Tell us your email address and we'll send you instructions on how to get back in</p>
        @include('parts.error')
        @if(Session::has('success'))
            <div class="alert alert-success">

                    <p>{!! (Session::get('success')) !!}</p>
            </div>
        @endif


        {!!Form::Open(['url'=> '/auth/password-reset','method' => 'post','class' => 'm-t'])!!}
        <div class="form-group">
            {!!Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Email'])!!}
        </div>

        <button type="submit" class="btn btn-primary block full-width m-b">Send me instructions</button>

        <a href="/auth/login">
            <small>Return to login</small>
        </a>
        </form>
   @stop