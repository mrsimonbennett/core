<!DOCTYPE html>
<html>
<head>
  @include('dashboard.layout.head')

</head>

<body>
<div id="wrapper">
   @include('dashboard.layout.left-sidebar')

    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            @include('dashboard.layout.header')
        </div>
        @yield('content')

    </div>

</div>

@include('dashboard.layout.scripts')
</body>
</html>
