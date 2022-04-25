@if (!empty($downloads) && count($downloads))
    <ul class="list-unstyled">
        @foreach ($downloads as $download)
            <li>
                {{-- <a class="download_name" href="{{ $download->link() }}" title="{{ $download->name }}"> --}}
                <a class="tw-mb-1 tw-block tw-no-underline hover:tw-underline tw-text-gray-900 tw-text-lg"
                    href="{{ route('repository-downloads.show', $download) }}" title="{{ $download->name }}">
                    {{ $download->name }}
                </a>
                <div class="tw-flex tw-text-gray-500 tw-gap-2 tw-text-xs">
                    <span>相关保存: </span>
                    <a class="tw-no-underline tw-text-gray-500 hover:tw-underline"
                        href="{{ route('repository_audio.show', [
                            'repository' => $repository,
                            'slug' => $repository->slug ?? null,
                            'commit' => $download->commit,
                        ]) }}">{{ $download->commit->title }}</a>

                </div>
                <div class="tw-text-sm tw-text-gray-500">
                    由
                    <a class="tw-no-underline tw-text-gray-500 hover:tw-underline"
                        href="{{ route('users.show', $download->user) }}">{{ $download->user->name }}</a>
                    创建于 {{ $download->created_at->diffForHumans() }}
                </div>

            </li>

            @if (!$loop->last)
                <hr>
            @endif
        @endforeach
    </ul>

    {{-- 分页 --}}
    <div class="mt-4">
        {!! $downloads->appends(Request::except('page'))->render() !!}
    </div>
@else
    <div class="empty-block">暂无下载 ~_~ </div>
@endif
