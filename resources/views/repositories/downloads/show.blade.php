@extends('layouts.repository')

@section('content')
    <div class="container mt-4" id="downloadShow">
        <div class="col-md-10 offset-md-1">
            <div class="card ">

                <div class="card-body">
                    <h2 class="">
                        {{ $download->name }}
                    </h2>


                    @if ($download->description)
                        {{-- <hr> --}}
                        {!! $download->description !!}
                    @endif


                    <hr>

                    {{-- <button onclick="onDownload()"
                        class="tw-rounded tw-px-4 tw-py-2 tw-bg-indigo-500 tw-text-white hover:tw-bg-indigo-600"
                        type="button">下载</button> --}}
                    <div class="tw-flex  tw-gap-2">
                        <span>相关保存: </span>
                        &nbsp;&nbsp;
                        <a class="tw-no-underline tw-text-inherit"
                            href="{{ route('repository_audio.show', [
                                'repository' => $download->repository,
                                'slug' => $download->repository->slug ?? null,
                                'commit' => $download->commit,
                            ]) }}">{{ $download->commit->title }}</a>

                    </div>


                    <p class="">
                        下载文件名: &nbsp;&nbsp;{{ $download->file_name }}
                    </p>
                    <download-button :download_id="{{ $download->id }}"></download-button>
                </div>
            </div>
        </div>
    </div>
@endsection
