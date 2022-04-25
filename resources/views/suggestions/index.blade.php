@extends('layouts.app')

@section('title', '建议列表')
@section('description', '建议列表')

@section('content')
    <div class=" tw-py-2 tw-max-w-3xl tw-mx-auto tw-mt-8">
        {{-- 用户回复列表 --}}
        <div class="tw-mb-4">
            <a href="{{ route('suggestions.create') }}" class="btn btn-success" aria-label="Left Align">
                <i class="fas fa-pencil-alt mr-2"></i> 新建议
            </a>
        </div>

        <div class="mt-4">
            <div class="tw-p-4 ">
                @include('suggestions._suggestion_list')
            </div>
        </div>
    </div>
@stop
