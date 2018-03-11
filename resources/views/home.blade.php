@extends('layouts.app')

@section('content')
<div id="homepage">
  <div class="container">
    <div class="row">
      <div class="col-sm">
        <div class="action-box">
          <div class="action-content">
            <a href="{{route('view_previous')}}">
              <span class="action-header">View Previous</span>
              <i class="fas fa-history fa-9x"></i>
            </a>
          </div>

        </div>
      </div>
      <div class="col-sm">
        <div class="action-box">
          <div class="action-content">
            <a href="{{route('add_new')}}">
              <span class="action-header">Add New</span>
              <i class="fas fa-chart-line fa-9x"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm">
        <div class="action-box">
          <div id="recent">
            <a href="{{route('add_new')}}">
              <span id="head">Most Recent</span>
            </a>
            <span>Title: {{ $recent->title }}</span>
            <span>Date Recorded: {{ $recent->experiment_started }}</span>
            <span>Length: {{ $recent->elapsed }}</span>
            <div class="data_chart"></div>
          </div>
        </div>
      </div>
      <div class="col-sm">
        <div class="action-box">
          <div class="action-content">
            <span class="action-header">Stats</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
data = {!! json_encode($data) !!};
</script>
<script src="{{ asset('js/chart_data.js') }}"></script>
@endsection
