@extends('layouts.app')

@yield('scripts')
@yield('styles')

@section('content')
<div style="width: 500px; height: 500px;">
    {!! Mapper::render() !!}
</div>
@endsection