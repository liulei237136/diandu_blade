@if (count($downloads))
    <ul class="list-unstyled">
        @foreach ($downloads as $download)
            <li>
                {{-- <a class="download_name" href="{{ $download->link() }}" title="{{ $download->name }}"> --}}
                <a class="download_name" href="{{ $download->url() }}" title="{{ $download->name }}">
                    {{ $download->name }}
                </a>
                <div class="download_meta">
                    创建于 {{ $download->created_at->diffForHumans() }}
                </div>

            </li>

            @if (!$loop->last)
                <hr>
            @endif
        @endforeach
    </ul>
@else
    <div class="empty-block">暂无下载 ~_~ </div>
@endif
