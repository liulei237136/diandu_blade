@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-10 offset-md-1">
            <div class="card ">

                <div class="card-body">
                    <h2 class="">
                        <i class="far fa-edit"></i>
                        @if ($repository->id)
                            编辑仓库
                        @else
                            新建仓库
                        @endif
                    </h2>

                    <hr>

                    @if ($repository->id)
                        <form action="{{ route('repositories.update', $repository->id) }}" method="POST" accept-charset="UTF-8">
                            <input type="hidden" name="_method" value="PUT">
                        @else
                            <form action="{{ route('repositories.store') }}" method="POST" accept-charset="UTF-8">
                    @endif

                    @csrf

                    @include('shared._error')

                    <div class="mb-3">
                        <input class="form-control" type="text" name="name" value="{{ old('name', $repository->name) }}"
                            placeholder="请填写仓库名" required />
                    </div>

                    {{-- <div class="mb-3">
                        <select class="form-control" name="category_id" required>
                            <option value="" hidden disabled selected>请选择分类</option>
                            @foreach ($categories as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}

                    <div class="mb-3">
                        <textarea name="description" class="form-control d-none" id="editor" rows="6" placeholder="请填入至少三个字符的描述。"
                            required>{{ old('description', $repository->description) }}</textarea>
                        {{-- <textarea name="description" id="editor"
                            required>{{ old('description', $repository->description) }}</textarea> --}}
                    </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary"><i class="far fa-save mr-2" aria-hidden="true"></i>
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
        textarea: $('#editor'),
      });
    });
  </script>
@stop
