@extends('errors.layout')

@section('title', 'Forbidden')
@section('code', '403')
@section('message', 'Access Forbidden')
@section('description', 'Sorry, you do not have permission to access this area. If you believe this is a mistake, please contact your administrator.')

@section('icon')
    <i class="fa-solid fa-ban text-3xl text-red-500"></i>
@endsection

@section('actions')
    <button onclick="history.back()" class="px-6 py-2.5 rounded-full border border-gray-200 text-gray-700 font-medium hover:bg-gray-50 transition-colors flex items-center justify-center gap-2">
        <i class="fa-solid fa-arrow-left"></i>
        Go Back
    </button>
@endsection
