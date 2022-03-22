@extends('layouts.repository')

@section('title', $repository->name)
@section('description', $repository->excerpt)


@section('content')
<div class="tw-p-4">
    <div class="operate">
        @can('update', $repository)
            <a href="{{ $repository->link('repository_audio.edit', [$repository->id]) }}" class="btn btn-outline-secondary btn-sm"
                role="button">
                <i class="far fa-edit"></i> 编辑
            </a>
            <hr>
        @endauth
    </div>
    <div class="tw-bg-white tw-py-4">
        <show-audio :repository="{{ $repository->toJson() }}" :commit="{{ isset($commit) ? $commit->toJson() : null }}"
            :can_edit="{{ auth()->check() &&
                auth()->user()->isAuthorOf($repository) }}">
        </show-audio>
    </div>

</div>
@stop
