@extends('layouts.app')

@section('title', @yield('title'))

@section('content')
    @include('layouts._repository_header')
    <div class="p-2">
        @yield('repository_content')
    </div>
@endsection
