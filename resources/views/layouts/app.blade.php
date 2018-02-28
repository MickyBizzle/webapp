<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">


  <!-- Styles -->

  <!-- Font Awesome -->
  <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
  <!-- Bootstrap -->
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <!-- jQuery toast  -->
  <link href="{{ asset('css/jquery.toast.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{route('home')}}">Data Viewer</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="{{route('home')}}">Home</a>
        </li>
        <li class="nav-item nav-link">|</li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('add_new')}}">Add New</a>
        </li>
        <li class="nav-item nav-link">|</li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('view_previous')}}">View Previous</a>
        </li>
        <li class="nav-item nav-link">|</li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('edit_hardware')}}">Change Hardware Authentication</a>
        </li>
      </ul>
    </div>
  </nav>

  @yield('content')

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('js/jquery.toast.min.js') }}"></script>

  @yield('scripts')
</body>
</html>
