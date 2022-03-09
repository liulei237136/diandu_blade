@extends('layouts.repository')

@section('title', $repository->name)
@section('description', $repository->excerpt)

@section('content')

  <div class="row">

    {{-- <div class="col-lg-3 col-md-3 hidden-sm hidden-xs author-info"> --}}
    <div class="col-lg-3 col-md-3 d-none d-md-block  author-info">
      <div class="card ">
        <div class="card-body">
          <div class="text-center">
            作者：{{ $repository->user->name }}
          </div>
          <hr>
          {{-- <div class="media">
            <div align="center">
              <a href="{{ route('users.show', $repository->user->id) }}">
                <img class="thumbnail img-fluid" src="{{ $repository->user->avatar }}" width="300px" height="300px">
              </a>
            </div>
          </div> --}}
          <div class="d-flex">

          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-9 col-md-9 col-sm-12 col-12 repository-content">
      <div class="card ">
        <div class="card-body">
          <h1 class="text-center mt-3 mb-3">
            {{ $repository->name }}
          </h1>

          <div class="article-meta text-center text-secondary">
            {{ $repository->created_at->diffForHumans() }}
            {{-- ⋅
            <i class="far fa-comment"></i>
            {{ $repository->reply_count }} --}}
          </div>

          <div class="repository-body mt-4 mb-4">
            {!! $repository->body !!}
          </div>

          <div class="operate">
            <hr>
            <a href="{{ route('repositories.edit', $repository->id) }}" class="btn btn-outline-secondary btn-sm" role="button">
              <i class="far fa-edit"></i> 编辑
            </a>
            {{-- <a href="#" class="btn btn-outline-secondary btn-sm" role="button">
              <i class="far fa-trash-alt"></i> 删除
            </a> --}}
          </div>

        </div>
      </div>
    </div>
  </div>
@stop
