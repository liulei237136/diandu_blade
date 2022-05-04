@extends('layouts.app')

@section('title', '搜索结果')

@section('content')

    <div class="row mb-5 mt-4">
        <div class="col-lg-9 col-md-9 repository-list">
            <div class="card ">
                <div class="card-header bg-transparent">
                    <h4>搜索结果:</h4>
                    <ul class="nav nav-pills">
                        <li class="nav-item " ><a class="nav-link {{active_class(if_query('order', 'default') || if_query('order', null))}}" href="{{request()->url()}}?q={{request()->q}}&order=default">最匹配</a></li>
                        <li class="nav-item"><a class="nav-link {{active_class(if_query('order', 'favorite'))}}" href="{{request()->url()}}?q={{request()->q}}&order=favorite">最多收藏</a></li>
                    </ul>
                </div>

                <div class="card-body">
                    {{-- 话题列表 --}}
                    @include('repositories._repository_list', [
                        'repositories' => $repositories,
                    ])
                    {{-- 分页 --}}
                    @if(!empty($repositories))
                    <div class="mt-5">
                        {!! $repositories->appends(Request::except('page'))->render() !!}
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- <div class="col-lg-3 col-md-3 sidebar">
            @include('repositories._sidebar')
        </div> --}}
    </div>

@endsection
