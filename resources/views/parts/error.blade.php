@if($errors->has())
    <div class="alert alert-warning">
        @foreach ($errors->all() as $error)

            <p>{!! $error !!}</p>
        @endforeach
    </div>
@endif