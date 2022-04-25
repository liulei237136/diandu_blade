@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="col-md-10 offset-md-1">
            <div class="card ">

                <div class="card-body">
                    <h2 class="">
                        <i class="far fa-edit"></i>
                        编辑建议
                    </h2>

                    <hr>

                    @include('shared._error')

                    <form action="{{ route('suggestions.update', $suggestion) }}" method="POST" accept-charset="UTF-8">

                        @csrf

                        @method('put')

                        <div class="form-group mb-3 ">
                            <label for="suggestion_title" class="tw-mb-1">建议标题:</label>
                            <input id="tuttorial_title" class="form-control " type="text"
                                name="title" value="{{ old('title', $suggestion->title) }}" placeholder="最少3个字符" />
                        </div>
                        <div class="form-group mb-3">
                            <label for="suggestion_content" class="tw-mb-1">建议内容:</label>
                            <textarea name="content" class="form-control " id="suggestion_content" rows="6"
                                placeholder="最少10个字符">{{ old('content', $suggestion->content) }}</textarea>

                        </div>

                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary"><i class="far fa-save mr-2"
                                    aria-hidden="true"></i>
                                更新</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


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
                textarea: $('#suggestion_content'),
                upload: {
                    url: '{{ route('suggestions.upload_image') }}',
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
