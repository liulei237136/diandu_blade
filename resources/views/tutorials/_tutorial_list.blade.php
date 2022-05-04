@if (count($tutorials))
    <ul class="list-unstyled">
        @foreach ($tutorials as $tutorial)
            <li>
                <a class="tw-mb-1 tw-block tw-no-underline hover:tw-underline tw-text-gray-900 tw-text-lg" href="{{route('tutorials.show', $tutorial)}}"
                    title="{{ $tutorial->title }}">
                    {{ $tutorial->title }}
                </a>
            </li>

            @if (!$loop->last)
                <hr>
            @endif
        @endforeach
    </ul>
@else
    <div class="empty-block">暂无教程 </div>
@endif
