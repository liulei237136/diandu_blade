@extends('layouts.app')

@section('title', '仓库')

@section('content')

    <div class="row mb-5 mt-4">
        <div class="col-lg-9 col-md-9 repository-list">

            <div class="card ">
                <div class="card-header bg-transparent">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link {{active_class(if_query('order', 'default') || if_query('order', null))}}" href="{{request()->url()}}?order=default">最新发布</a></li>
                        <li class="nav-item"><a class="nav-link {{active_class(if_query('order', 'star'))}}" href="{{request()->url()}}?order=star">最多收藏</a></li>
                    </ul>
                </div>

                <div class="card-body">
                    {{-- 话题列表 --}}
                    @include('repositories._repository_list', [
                        'repositories' => $repositories,
                    ])
                    {{-- 分页 --}}
                    <div class="mt-5">
                        {!! $repositories->appends(Request::except('page'))->render() !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 sidebar">
            @include('repositories._sidebar')
        </div>
    </div>

@endsection
