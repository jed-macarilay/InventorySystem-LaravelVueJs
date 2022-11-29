@extends('layouts.app')

@section('content')
    <change-password 
        :auth="{{ auth()->user() }}"
    />
@endsection