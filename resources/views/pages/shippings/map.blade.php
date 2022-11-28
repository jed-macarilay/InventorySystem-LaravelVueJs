@extends('layouts.app')

@section('content')
    <map-index
        :shipping="{{ $shipping }}"
        driver="{{ $driver }}"
    />
@endsection