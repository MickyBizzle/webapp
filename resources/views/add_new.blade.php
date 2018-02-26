@extends('layouts.app')

@section('content')
<div id="add_new_page">
  <div class="head_bar">
    <div class="head_contain">
      <span id="title">
        <input class="title_in" placeholder="Insert title here">
      </span>
      <span id="time">Time Elapsed: 00:00:00</span>
    </div>
    <div class="head_contain">
      <span id="started">Created At: <div style="display:inline;font-size:16px;opacity:0.8;">Will update automatically</div></span>
      <span id="data_connect">Receiving Data: <div id="status" class="bg-danger">NO</div></span>
    </div>
    <button type="button" class="btn btn-success start_stop">Start</button>
  </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/add_new.js') }}"></script>
@endsection
