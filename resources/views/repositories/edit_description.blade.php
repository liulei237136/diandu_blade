@extends('layouts.repository')

@section('title', $repository->name)
@section('description', $repository->excerpt)

@section('content')
    <div class="tw-py-8">
        <div class="container ">
            <div class="card ">

                <div class="card-body">
                    <h2 class="">
                        <i class="far fa-edit"></i>
                        编辑仓库描述
                    </h2>

                    <hr>
                    <form action="{{ route('repositories.update_description', $repository->id) }}" method="POST"
                        accept-charset="UTF-8">
                        @csrf
                        @method('put')

                        <textarea name="description" class="form-control " id="editor" rows="6" placeholder="请填入至少三个字符的描述。"
                            required>{{ old('description', $repository->description) }}</textarea>


                        <button type="submit" class="btn btn-primary tw-mt-4"><i class="far fa-save mr-2"
                                aria-hidden="true"></i>
                            保存</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/simditor.css') }}">
@stop

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/module.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/hotkeys.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/uploader.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/simditor.js') }}"></script>

    <script>
        $(document).ready(function() {
            var editor = new Simditor({
                textarea: $('#editor'),
                upload: {
                    url: '{{ route('repositories.upload_image') }}',
                    params: {
                        _token: '{{ csrf_token() }}'
                    },
                    fileKey: 'upload_file',
                    connectionCount: 3,
                    leaveConfirm: '文件上传中，关闭此页面将取消上传。'
                },
                pasteImage: true,
            });
        });
    </script>
@stop
