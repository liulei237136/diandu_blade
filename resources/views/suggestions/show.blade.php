@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="col-md-10 offset-md-1">
            <div class="card ">

                <div class="card-body">
                    <h2>
                        {{ $suggestion->title }}
                    </h2>

                    <p class="text-muted">由{{ $suggestion->user->name }} 创建于
                        {{ $suggestion->created_at->diffForHumans() }}
                    </p>

                    {!! $suggestion->content !!}


                    @can('update', $suggestion)
                        <hr>
                        <div class="tw-flex ">
                            <a href="{{ route('suggestions.edit', $suggestion) }}" class="btn btn-primary tw-mr-2"><i
                                    class="far fa-edit mr-2" aria-hidden="true"></i>
                                编辑</a>
                            <form method="POST" action="{{ route('suggestions.destroy', $suggestion) }}">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger"><i class="far fa-trash-can mr-2"
                                        aria-hidden="true"></i>
                                    删除</button>
                            </form>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
