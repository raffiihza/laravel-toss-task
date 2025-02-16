@extends('layouts.base')
@section('title', 'Dashboard')

@section('content')
    <div class="bg-white p-6 shadow rounded-lg">
        <h2 class="text-2xl font-semibold text-gray-700">Selamat datang, {{ Auth::user()->name }}!</h2>
    </div>
@endsection
