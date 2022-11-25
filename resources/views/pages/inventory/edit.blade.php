@extends('layouts.app')

@section('content')
    <inventory-edit 
        :product="{{ $inventory }}"
    />
@endsection