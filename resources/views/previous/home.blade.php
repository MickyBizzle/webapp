@extends('layouts.app')

@section('content')
<div id="view_previous">
  @if($noData)
  <table id="noDataTable">
    <thead>
      <tr>
        <th class="text-danger">Experiments with no data. Recommend deletion</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($noData as $row)
      <tr>
        <td id="noData">{{ $row->title }}</td>
        <td id="noData">
          <a href="{{ route('delete_experiment', ['id' => $row->id]) }}" onclick="return confirm('Are you sure you want to delete this experiment?')">Delete</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @endif
  <div class="table-head">
    <a class="btn btn-primary text-white" href="{{route('view_previous')}}">View all</a>
    <a class="btn btn-primary text-white" href="{{route('view_previous', ['show' => 'training'])}}">View training data</a>
    <a class="btn btn-primary text-white" href="{{route('view_previous', ['show' => 'non_training'])}}">View non-training data</a>
    <a class="btn btn-primary text-white" href="{{route('view_previous', ['show' => 'random'])}}">View random data</a>
    {{ $experiments->links() }}
  </div>
  <table>
    <thead>
      <tr>
        <th>Title</th>
        <th>Training Data</th>
        <th>Media Type</th>
        <th>Emotional Response</th>
        <th>Time Started</th>
        <th>Time Elapsed</th>
        <th id="actions">Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($experiments as $experiment)
      <tr id="row{{$experiment->id}}">
        <td onclick="window.location='{{route('show_experiment', ['id' => $experiment->id])}}'"> {{ $experiment->title }} </td>
        <td>
          <input type="checkbox" <?php if ($experiment->is_training_data) echo "checked";?> id="{{$experiment->id}}" class="training_check">
        </td>
        <td>
          <select id="{{$experiment->id}}" class="media_select">
            <option value="1" <?php if ($experiment->media_type == 1) echo "selected"; ?>>Video</option>
            <option value="2" <?php if ($experiment->media_type == 2) echo "selected"; ?>>Music</option>
            <option value="3" <?php if ($experiment->media_type == 3) echo "selected"; ?>>Image</option>
          </select>
        </td>
        <td>
          <select <?php if (!$experiment->is_training_data) echo "disabled"; ?> id="{{$experiment->id}}" class="response_select">
            <option value="0" disabled hidden <?php if ($experiment->emotional_response == 0) echo "selected"; ?>>N/A</option>
            <option value="1" <?php if ($experiment->emotional_response == 1) echo "selected"; ?>>Anger</option>
            <option value="2" <?php if ($experiment->emotional_response == 2) echo "selected"; ?>>Disgust</option>
            <option value="3" <?php if ($experiment->emotional_response == 3) echo "selected"; ?>>Fear</option>
            <option value="4" <?php if ($experiment->emotional_response == 4) echo "selected"; ?>>Happiness</option>
            <option value="5" <?php if ($experiment->emotional_response == 5) echo "selected"; ?>>Sadness</option>
            <option value="6" <?php if ($experiment->emotional_response == 6) echo "selected"; ?>>Surprise</option>
          </select>
        </td>
        <td onclick="window.location='{{route('show_experiment', ['id' => $experiment->id])}}'"> {{ $experiment->experiment_started }} </td>
        <td onclick="window.location='{{route('show_experiment', ['id' => $experiment->id])}}'"> {{ $experiment->elapsed }} </td>
        <td id="actions">
          <a class="edit" id="{{$experiment->id}}" title="{{$experiment->title}}"href="">Edit Title</a>
          <a href="{{ route('delete_experiment', ['id' => $experiment->id]) }}" onclick="return confirm('Are you sure you want to delete this experiment?')">Delete</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  {{ $experiments->links() }}

  <div class="modal fade" id="titleModal">
    <div class="modal-dialog" rol="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input class="modal-input-title" style="padding:0 5px;" placeholder="Insert title here">
          <button class="btn btn-secondary confirm" data-dismiss="modal">Cancel</button>
          <button class="btn btn-primary confirm save">Save</button>
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
<script src="{{ asset('js/change_title.js') }}"></script>
<script src="{{ asset('js/view_previous.js') }}"></script>
@endsection
