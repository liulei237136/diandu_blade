@extends('layouts.repository')

@section('content')
    <div class="container mt-4" id="downloadShow">
        <div class="col-md-10 offset-md-1">
            <div class="card ">

                <div class="card-body">
                    <h2 class="">
                        {{ $download->name }}
                    </h2>

                    <p class="tw-text-base">
                        文件名: &nbsp;&nbsp;{{ $download->file_name }}
                    </p>

                    @if ($download->description)
                        <hr>
                        {!! $download->description !!}
                    @endif

                    <hr>

                    {{-- <button onclick="onDownload()"
                        class="tw-rounded tw-px-4 tw-py-2 tw-bg-indigo-500 tw-text-white hover:tw-bg-indigo-600"
                        type="button">下载</button> --}}
                    <download-button :download_id="{{ $download->id }}"></download-button>
                </div>
            </div>
        </div>
    </div>
@endsection

