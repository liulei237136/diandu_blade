@extends('layouts.repository')

@section('title', $repository->name)
@section('description', $repository->excerpt)

@section('content')
    <div class="tw-bg-white tw-py-2 tw-max-w-3xl tw-mx-auto">
        {{-- 用户回复列表 --}}
        <div class="card repository-download mt-4">
            <div class="card-body">
                {{-- @includeWhen(auth()->check(), 'repositories._download_box') --}}
                @can('update', $repository)
                    <div>
                        <button class="btn btn-primary ">新建下载</button>
                        <a href="{{ route('repository-downloads.create') }}" class="btn btn-success tw-w-full" aria-label="Left Align">
                            <i class="fas fa-pencil-alt mr-2"></i> 新建仓库
                        </a>
                    </div>
                @endcan
                @include('repositories._download_list')

                {{-- 分页 --}}
                <div class="mt-4">
                    {!! $downloads->appends(Request::except('page'))->render() !!}
                </div>
            </div>
        </div>
    </div>
@stop
