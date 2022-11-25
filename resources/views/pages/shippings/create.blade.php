@extends('layouts.app')

@section('content')
    <shipping-create 
        :vehicle="{{ $vehicle }}"
    />
@endsection