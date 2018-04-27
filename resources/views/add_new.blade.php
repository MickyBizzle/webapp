@extends('layouts.app')

@section('content')
<div id="add_new_page">
  <div class="head_bar">
    <div class="head_contain">
      <span id="title">
        <input class="title_in" placeholder="Insert title here">
        <label>Use as training data? <input type="checkbox" class="is_training_data"></label>
      </span>
      <span id="time">Time Elapsed: <div class="timer" style="display:inline">00:00:00</div></span>
    </div>
    <div class="head_contain">
      <span id="started">Created At: <div style="display:inline;font-size:16px;opacity:0.8;">Will update automatically</div></span>
      <span id="data_connect">Receiving Data: <div id="status" class="bg-danger">NO</div></span>
    </div>
    <a href="./add_new">
      <button type="button" class="btn btn-primary new_exp">New experiment</button>
    </a>
    <button type="button" class="btn btn-success start_stop">Start</button>
  </div>
  <div class="data_chart"></div>

  <div class="modal fade" id="emotionModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" rol="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Enter emotional response and media type</h5>
          <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col">
              <label>Anger <br>
              <input type="radio" name="emotion" value="1"></label>
            </div>
            <div class="col">
              <label>Disgust <br>
              <input type="radio" name="emotion" value="2"></label>
            </div>
            <div class="col">
              <label>Fear <br>
              <input type="radio" name="emotion" value="3"></label>
            </div>
            <div class="col">
              <label>Happiness <br>
              <input type="radio" name="emotion" value="4"></label>
            </div>
            <div class="col">
              <label>Sadness <br>
              <input type="radio" name="emotion" value="5"></label>
            </div>
            <div class="col">
              <label>Surprise <br>
              <input type="radio" name="emotion" value="6"></label>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label>Video <br>
              <input type="radio" name="media" value="1"></label>
            </div>
            <div class="col">
              <label>Music <br>
              <input type="radio" name="media" value="2"></label>
            </div>
            <div class="col">
              <label>Image <br>
              <input type="radio" name="media" value="3"></label>
            </div>
          </div>
          <button class="btn btn-primary confirm save">Save</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="mediaModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" rol="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Enter media type</h5>
          <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col">
              <label>Video <br>
              <input type="radio" name="media" value="1"></label>
            </div>
            <div class="col">
              <label>Music <br>
              <input type="radio" name="media" value="2"></label>
            </div>
            <div class="col">
              <label>Image <br>
              <input type="radio" name="media" value="3"></label>
            </div>
          </div>
          <button class="btn btn-primary confirm save media">Save</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
url = {!! json_encode($url) !!};
</script>
<script src="{{ asset('js/jquery.stopwatch.js') }}"></script>
<script src="{{ asset('js/add_new.js') }}"></script>
@endsection
