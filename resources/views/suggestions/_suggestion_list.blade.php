@if (count($suggestions))
    <ul class="list-unstyled">
        @foreach ($suggestions as $suggestion)
            <li>
                <a class="tw-mb-1 tw-block tw-no-underline hover:tw-underline tw-text-gray-900 tw-text-lg"
                    href="{{ route('suggestions.show', $suggestion) }}" title="{{ $suggestion->title }}">
                    {{ $suggestion->title }}
                </a>
                <p class="text-muted tw-text-sm">由{{ $suggestion->user->name }} 创建于
                    {{ $suggestion->created_at->diffForHumans() }}
                </p>
            </li>

            @if (!$loop->last)
                <hr>
            @endif
        @endforeach
    </ul>

    <div class="tw-mt-8">
        {{$suggestions->render()}}
    </div>
@else
    <div class="empty-block">暂无建议 </div>
@endif
