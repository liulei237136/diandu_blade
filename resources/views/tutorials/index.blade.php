@extends('layouts.app')

@section('title', '教程')
@section('description', '网站教程')

@section('content')
    <div class="tw-bg-white tw-py-2 tw-max-w-3xl tw-mx-auto">
        {{-- 用户回复列表 --}}
        @if (auth()->check() &&
    auth()->user()->isAdmin())
            <div class="tw-mb-4">
                <a href="{{ route('tutorials.create') }}" class="btn btn-success" aria-label="Left Align">
                    <i class="fas fa-pencil-alt mr-2"></i> 新建教程
                </a>
            </div>
        @endif
    @endcan
    <div class="repository-download mt-4">
        <div class="">
            @include('repositories._download_list')
        </div>
    </div>
</div>
@stop
