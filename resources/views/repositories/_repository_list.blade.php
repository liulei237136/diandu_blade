@if (count($repositories))
    <ul class="list-unstyled">
        @foreach ($repositories as $repository)
            <li>
                <a class="repository_name" href="{{ $repository->link() }}" title="{{ $repository->name }}">
                    {{ $repository->name }}
                </a>
                <div class="repository_meta">
                    由
                    <a href="#">
                        {{ $repository->user->name }}
                    </a>
                    创建于 {{ $repository->created_at->diffForHumans() }}
                </div>

            </li>

            @if (!$loop->last)
                <hr>
            @endif
        @endforeach
    </ul>
@else
    <div class="empty-block">暂无数据 ~_~ </div>
@endif
