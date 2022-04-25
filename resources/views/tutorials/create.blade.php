@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="col-md-10 offset-md-1">
            <div class="card ">

                <div class="card-body">
                    <h2 class="">
                        <i class="far fa-edit"></i>
                        新建教程
                    </h2>

                    <hr>

                    <form action="{{ route('tutorials.store') }}" method="POST" accept-charset="UTF-8">

                        @csrf

                        {{-- @include('shared._error') --}}

                        <div class="form-group mb-3">
                            <label for="tutorial_title">教程标题</label>
                            <input id="tuttorial_title" class="form-control @error('title') is-invalid @enderror" type="text"
                                name="title" value="{{ old('title', $tutorial->title) }}" placeholder="" required />
                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="tutorial_order">教程排序</label>
                            <input id="tutorial_order" class="form-control @error('order') is-invalid @enderror" type="number"
                                name="order" value="{{ old('order', $tutorial->order) }}" placeholder="" required />
                            @error('order')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="tutorial_content">教程内容·</label>
                            <textarea name="content" class="form-control " id="tutorial_content" rows="6" placeholder=""
                                required>{{ old('content', $tutorial->content) }}</textarea>
                        </div>

                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary"><i class="far fa-save mr-2"
                                    aria-hidden="true"></i>
                                保存</button>
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
                textarea: $('#tutorial_content'),
                upload: {
                    url: '{{ route('tutorials.upload_image') }}',
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
