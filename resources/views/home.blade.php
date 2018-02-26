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
            <span id="head">Most Recent</span>
            <span>Title: </span>
            <span>Date Recorded: </span>
            <span>Length: </span>
          </div>
        </div>
      </div>
      <div class="col-sm">
        <div class="action-box">
          <div class="action-content">
          </div>
          Hello
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
