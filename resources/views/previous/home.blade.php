@extends('layouts.app')

@section('content')
<div id="view_previous">
  {{ $experiments->links() }}
  <table>
    <thead>
      <tr>
        <th>Title</th>
        <th>Time Started</th>
        <th>Time Elapsed</th>
        <th id="actions">Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($experiments as $experiment)
      <tr>
        <td onclick="window.location='{{route('show_experiment', ['id' => $experiment->id])}}'"> {{ $experiment->title }} </td>
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
<script src="{{ asset('js/change_title.js') }}"></script>
@endsection
