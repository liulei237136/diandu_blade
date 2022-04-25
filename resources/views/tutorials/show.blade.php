@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="col-md-10 offset-md-1">
            <div class="card ">

                <div class="card-body">
                    <h2 class="">
                        {{ $tutorial->title }}
                    </h2>

                    {!! $tutorial->content !!}


                    @if (auth()->check() && auth()->user()->isAdmin())
                    <hr>
                        <div class="tw-flex ">
                            <a href="{{ route('tutorials.edit', $tutorial) }}" class="btn btn-primary tw-mr-2" ><i
                                    class="far fa-edit mr-2" aria-hidden="true"></i>
                                编辑</a>
                            <form action="{{ route('tutorials.destroy', $tutorial) }}">
                                @csrf
                                @method('put')
                                <button type="submit" class="btn btn-danger"><i class="far fa-trash-can mr-2"
                                        aria-hidden="true"></i>
                                    删除</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
