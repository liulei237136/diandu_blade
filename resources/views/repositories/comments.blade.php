@extends('layouts.repository')

@section('title', $repository->name)
@section('description', $repository->excerpt)

@section('repository_content')
    <div class="tw-bg-white tw-py-2 tw-max-w-3xl tw-mx-auto">
        {{-- 用户回复列表 --}}
        <div class="card repository-comment mt-4">
            <div class="card-body">
                @includeWhen(auth()->check(), 'repositories._comment_box')
                @include('repositories._comment_list')

                {{-- 分页 --}}
                <div class="mt-4">
                    {!! $comments->appends(Request::except('page'))->render() !!}
                </div>
            </div>
        </div>
    </div>
@stop
