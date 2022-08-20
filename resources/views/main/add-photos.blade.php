@extends('layouts.app')

@yield('scripts')
@yield('styles')

@section('content')
<script type="text/javascript">

</script>

<div class="container" style="padding: 15px">
    {{ Form::open(['route' => 'add-photos', 'method' => 'GET']) }}
    <h2>Add photos</h2>
    <br>
    <label for="country">Select a country</label>
    <br>
    <select class="custom-select" name="country" id="country" required style="width: 300px">
        <option selected>Choose...</option>
        @foreach ($countries as $name)
        <option value="{{ $name->id }}">{{ $name->country_name }}</option>
        @endforeach
    </select>
    <br><br>
    
    @if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
        {{ $error }}
        @endforeach
    </div>
    @endif
    
    <label for="city">Name of the city</label>
    <br>
    <input type="text" name="city" id="city" style="width: 200px"/>
    <br><br>
    <label for="url">URL page</label>
    <br>
    <textarea name="url" id="url" cols="45"></textarea>
    <br><br>
    <label for="pages">Pages</label>
    <br>
    <input type="text" name="pages" id="pages" style="width: 200px"/>
    <br><br>
    {{ Form::submit('Send') }}
    {{ Form::close() }}
</div>
@endsection
