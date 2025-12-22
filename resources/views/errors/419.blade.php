@extends('errors.layout')

@section('title', 'Page Expired')
@section('code', '419')
@section('message', 'Page Expired')
@section('description', 'Your session has expired due to inactivity. Please refresh the page and try again.')

@section('icon')
    <i class="fa-solid fa-hourglass-end text-3xl text-brand-gold"></i>
@endsection

@section('actions')
    <button onclick="window.location.reload()" class="px-6 py-2.5 rounded-full border border-gray-200 text-gray-700 font-medium hover:bg-gray-50 transition-colors flex items-center justify-center gap-2">
        <i class="fa-solid fa-rotate-right"></i>
        Refresh Page
    </button>
@endsection

@section('hide_home', true) 
{{-- We hide the home button here to encourage refreshing the current form submission if possible, or we can keep it. Actually, users often want to just go home if they are stuck. But 'hide_home' logic is good to have. Let's keep home button for 419 as a fallback? No, usually 419 is annoying during form submit. Reload is best. --}}
