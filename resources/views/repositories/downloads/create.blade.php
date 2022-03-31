@extends('layouts.repository')

@section('content')
 {{-- {{dump($tempKeys)}} --}}
    <div class="container mt-4">
        <div class="col-md-10 offset-md-1">
            <div class="card ">

                <div class="card-body">
                    <h2 class="">
                        <i class="far fa-edit"></i>
                        新建下载
                        {{-- {{$tempKeys}} --}}
                        {{-- @json($tempKeys) --}}
                    </h2>

                    <hr>

                    <form action="{{ route('repository-downloads.store', $repository->id) }}" method="POST"
                        accept-charset="UTF-8">

                        @csrf

                        @include('shared._error')

                        <div class="mb-3">
                            <upload-download :user_id="{{auth()->id()}}" :repository_id="{{$repository->id}}"></upload-download>
                        </div>

                        <div class="mb-3">
                            <select class="form-control" name="commit_id" id="commit_id" required>
                                <option value="" hidden disabled selected>选择对应的保存(必选)</option>
                                @foreach ($repository->commits as $commit)
                                    <option value="{{ $commit->id }}">{{ $commit->title }}</option>
                                @endforeach
                            </select>
                        </div>



                        <div class="mb-3">
                            <input class="form-control" type="text" name="name"
                                value="{{ old('name', $download->name) }}" placeholder="请填写下载名(必填)" required />
                        </div>

                        <div class="mb-3">
                            <textarea name="description" class="form-control " id="editor" rows="6" placeholder="请填入下载描述(可选填)"
                                >{{ old('description', $download->description) }}</textarea>
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/module.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/hotkeys.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/uploader.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/simditor.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // 防止误点链接
        window.onbeforeunload = function(event) {
            return confirm('really');
        };

        $(document).ready(function() {
            //sim
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


            //select2
            $('#commit').select2();
        });

        $(document).on('file_path', function(e,f){
            console.log('e', e);
            console.log('f', f);
        });
    </script>
@stop
