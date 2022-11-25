@extends('layouts.app')

@section('content')
    <shipping-index 
        :vehicle="{{ $vehicle }}"
    />
@endsection