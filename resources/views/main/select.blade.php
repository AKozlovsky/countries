@extends('layouts.app')

@yield('scripts')
<script src="{{ asset('js/loading-bar/loading-bar.js') }}"></script>

@yield('styles')
<link href="{{ asset('css/loading-bar/loading-bar.css') }}" rel="stylesheet">

@section('content')
    <div data-preset="energy" class="ldBar label-center" data-value="50" style="width:100%;height:30px;margin-top:30px"></div>
@endsection