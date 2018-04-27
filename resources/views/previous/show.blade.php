@extends('layouts.app')

@section('content')
<div id="show">
  <h1>Viewing results for experiment: {{ $experiment->title }}</h1>

  <div class="data_chart"></div>
</div>
@endsection

@section('scripts')
<script>
data = {!! json_encode($data) !!};
id = {!! json_encode($id) !!};
</script>
<script src="{{ asset('js/chart_data.js') }}"></script>
@endsection
