@extends('errors.layout')

@section('title', 'Service Unavailable')
@section('code', '503')
@section('message', 'Service Unavailable')
@section('description', 'We are currently performing scheduled maintenance. Please check back shortly.')

@section('icon')
    <i class="fa-solid fa-screwdriver-wrench text-3xl text-brand-green"></i>
@endsection

@section('actions')
    <button onclick="window.location.reload()" class="px-6 py-2.5 rounded-full border border-gray-200 text-gray-700 font-medium hover:bg-gray-50 transition-colors flex items-center justify-center gap-2">
        <i class="fa-solid fa-rotate-right"></i>
        Check Again
    </button>
@endsection
