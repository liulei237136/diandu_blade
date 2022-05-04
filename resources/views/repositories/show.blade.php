@extends('layouts.repository')

@section('title', $repository->name)
@section('description', $repository->excerpt)

@section('content')
    <div class="tw-bg-white tw-py-4">
        <div class="container ">
            <div class="operate">
                @can('update', $repository)
                <a href="{{$repository->link('repositories.edit_description')}}" class="btn btn-outline-secondary btn-sm"
                    role="button">
                    <i class="far fa-edit"></i> 编辑
                </a>
                <hr>
                @endauth
            </div>
            <div class="repository-description">
                {!! $repository->description !!}
            </div>
        </div>
    </div>
@stop
