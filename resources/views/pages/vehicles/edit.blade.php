@extends('layouts.app')

@section('content')
    <vehicle-edit 
        :vehicle="{{ $vehicle }}"
    />
@endsection