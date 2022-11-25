@extends('layouts.app')

@section('content')
    <change-password 
        :auth-id="{{ auth()->user()->id }}"
    />
@endsection