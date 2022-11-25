@extends('layouts.app')

@section('content')
    <shipping-edit 
        :shipping="{{ $shipping }}"
    />
@endsection