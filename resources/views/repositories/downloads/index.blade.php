@extends('layouts.repository')

@section('title', $repository->name)
@section('description', $repository->excerpt)

@section('repository_content')
    <div class="tw-bg-white tw-py-2 tw-max-w-3xl tw-mx-auto">
        {{-- 用户回复列表 --}}
        @can('update', $repository)
        <div class="tw-mb-4">
            <a href="{{ route('repository-downloads.create', $repository->id) }}" class="btn btn-success"
                aria-label="Left Align">
                <i class="fas fa-pencil-alt mr-2"></i> 新建下载
            </a>
        </div>
        @endcan
        <div class="repository-download mt-4">
            <div class="">
                @include('repositories._download_list')

                {{-- 分页 --}}
                <div class="mt-4">
                    {!! $downloads->appends(Request::except('page'))->render() !!}
                </div>
            </div>
        </div>
    </div>
@stop
