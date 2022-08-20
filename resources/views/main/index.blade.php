@extends('layouts.app')

@yield('scripts')
@yield('styles')

@section('content')
<script src="{{ asset('js/bootstrap-table.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-table-en-US.min.js') }}"></script>
<link href="{{ asset('css/bootstrap-table.min.css') }}" rel="stylesheet">

<script type="text/javascript">

function initTable(countryName, countries, cities) {
    var list = [];
    var obj = {};

    var listCountries = countries.split(';');
    var listCities = cities.split(';');

    $.each(listCountries, function (key, val) {
        if (val == countryName) {
            obj = {};
            obj.city = listCities[key];
            list.push(obj);
        }
    });

    $('#table').bootstrapTable({
        height: $(window).height() - $('h1').outerHeight(true),
        columns: [
            [
                {
                    field: 'city',
                    align: 'center',
                    valign: 'center',
                    sortable: true,
                    title: 'City name'
                },
                {
                    field: 'detail',
                    align: 'center',
                    valign: 'center',
                    title: 'Photos',
                    events: operateEvents,
                    formatter: operateFormatter
                }
            ]
        ],
        data: list
    });

    $('#table').bootstrapTable('load', list);
    $('#table')[0].style.display = '';
}

function operateFormatter(value, row, index) {
    return [
        '<button id="clickButton" type="button" class="btn btn-outline-secondary">Go to gallery</button>'
    ].join('');
}

window.operateEvents = {
    'click .btn': function (e, value, row, index) {
        window.location.href = "select/photo/" + row.city;
    }
};
</script>

<div class="jumbotron">
</div>

<div class="container">

    {{ Form::open(['route' => 'select-country', 'method' => 'GET'])}}

    <select class="custom-select" name="country" required="true" onchange="initTable(this.value, '<?php echo implode(";", $cities['country']); ?>', '<?php echo implode(";", $cities['city']); ?>');">
        <option selected>Choose...</option>
        @foreach ($countries as $name)
        <option value="{{ $name }}">{{ $name }}</option>
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

    <div style="margin: 0 50px 50px 50px;">
        <table id="table" data-search="true" style="display: none"></table>
    </div>

    {{ Form::close() }}
</div>
@endsection
