@extends('layouts.repository')

@section('title', $repository->name)
@section('description', $repository->excerpt)

@section('content')
    <div class="tw-bg-white tw-py-4">
        <div class="container ">
            <div class="repository-description">
                {!! $repository->description !!}
            </div>
            <div class="operate">
                <hr>
                <a href="{{ route('repositories.edit', $repository->id) }}" class="btn btn-outline-secondary btn-sm"
                    role="button">
                    <i class="far fa-edit"></i> 编辑
                </a>
            </div>
        </div>
    </div>


@stop
