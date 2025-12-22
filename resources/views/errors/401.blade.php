@extends('errors.layout')

@section('title', 'Unauthorized')
@section('code', '401')
@section('message', 'Unauthorized Access')
@section('description', 'You are not authorized to access this page. Please log in with the correct credentials to continue.')

@section('icon')
    <i class="fa-solid fa-user-lock text-3xl text-brand-green"></i>
@endsection

@section('actions')
    <a href="{{ route('staff.login') }}" class="px-6 py-2.5 rounded-full border border-gray-200 text-gray-700 font-medium hover:bg-gray-50 transition-colors flex items-center justify-center gap-2">
        <i class="fa-solid fa-right-to-bracket"></i>
        Log In
    </a>
@endsection
