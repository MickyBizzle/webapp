@extends('layouts.app')

@section('content')
<h1>Edit settings</h1>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
@endsection
@section('scripts')
<script src="{{ asset('js/edit_hardware.js') }}"></script>
@endsection
