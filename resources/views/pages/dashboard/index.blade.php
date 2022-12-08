@extends('layouts.app')

@section('content')
    <dashboard 
        :user="{{ auth()->user() }}"
    />
@endsection