@extends('layouts.repository')

@section('title', $repository->name)
@section('description', $repository->excerpt)

@section('content')
    <div class="tw-bg-white tw-py-8">
        <div class=" tw-max-w-3xl tw-mx-auto tw-p-6">
            {{-- <div class="operate">
                <a href="{{ route('repositories.edit_description', $repository->id) }}" class="btn btn-outline-secondary btn-sm"
                    role="button">
                    <i class="far fa-edit"></i> 编辑
                </a>
                <hr>
            </div>
            <div class="repository-description">
                {!! $repository->description !!}
            </div> --}}
            <form action="{{ route('repositories.update_name', $repository->id) }}" method="POST" accept-charset="UTF-8">

                @csrf
                @method('put')

                @include('shared._error')

                <div class="mb-3">
                    <input class="form-control" type="text" name="name" value="{{ old('name', $repository->name) }}"
                        placeholder="请填写仓库名" required />
                </div>
                <div class="tw-flex tw-justify-end">
                    <button type="submit" class="btn btn-primary"><i class="far fa-save mr-2" aria-hidden="true"></i>
                        更新仓库名</button>
                </div>
            </form>

            <hr>

            <form class="tw-my-10" action="{{ route('repositories.destroy', $repository->id) }}"
                onsubmit="return confirm('您确定要删除吗？');" method="POST" accept-charset="UTF-8">

                @csrf
                @method('delete')
                <p>
                    在删除您的账户之前，请下载您希望保留的任何数据或信息。
                </p>
                <div class="tw-flex tw-justify-end">
                    <button type="submit" class="btn btn-danger"><i class="fa-regular fa-trash-can mr-2"
                            aria-hidden="true"></i>
                        删除仓库</button>
                </div>
            </form>

        </div>
    </div>
@stop
