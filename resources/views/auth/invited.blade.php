@extends('auth.layout.master')
@section('content')

        <p>Please complete the form to finish off your application</p>

        <p>Use the same email address that the invite was sent to
            <small>(you can always change it once you have registered)</small>
        </p>
        @include('parts.error')
        @if(Session::has('notify'))
            <div class="alert alert-success">
                @foreach (Session::get('notify') as $error)
                    <p>{!! $error['title'] !!} <br>
                        <small>{{$error['text']}}</small>
                    </p>
                @endforeach
            </div>
        @endif

        {!!Form::Open(['url'=> "/auth/invited/{$token}",'method' => 'post','class' => 'm-t'])!!}
        <div class="form-group">
            {!!Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Email'])!!}
        </div>
        <div class="form-group">
            {!!Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password'])!!}
        </div>
        <div class="form-group">
            {!!Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm Password'])!!}
        </div>
        <div class="form-group">
            {!!Form::text('legal_name', null, ['class' => 'form-control', 'placeholder' => 'Your Legal Name (e.g. Mr John Smith)'])!!}
        </div>
        <div class="form-group">
            {!!Form::text('known_as', null, ['class' => 'form-control', 'placeholder' => 'Known As (e.g. Johnny)'])!!}
        </div>
        <button type="submit" class="btn btn-primary block full-width m-b">Complete Registration</button>


        </form>
 @stop