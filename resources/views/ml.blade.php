@extends('layouts.app')

@section('content')
<div id="ml">
  <h1>Last trained: {{$last_trained}}</h1>
  <h1>Time taken: {{$time_taken}}</h1>
  <button class="btn btn-danger train" <?php if($is_training) echo "disabled" ?>>Train ML</button>
</div>
@endsection

@section('scripts')
<script>
url = {!! json_encode($url) !!};
</script>
<script src="{{ asset('js/ml.js') }}"></script>
@endsection
