@extends('errors.layout')

@section('title', 'Too Many Requests')
@section('code', '429')
@section('message', 'Too Many Requests')
@section('description', 'You have sent too many requests in a given amount of time. Please wait a moment and try again.')

@section('icon')
    <i class="fa-solid fa-gauge-high text-3xl text-brand-gold"></i>
@endsection

@section('actions')
    <button onclick="window.location.reload()" class="px-6 py-2.5 rounded-full border border-gray-200 text-gray-700 font-medium hover:bg-gray-50 transition-colors flex items-center justify-center gap-2">
        <i class="fa-solid fa-rotate-right"></i>
        Try Again
    </button>
@endsection
