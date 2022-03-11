<ul class="list-unstyled">
    @foreach ($comments as $index => $repository)
      <li class="d-flex" name="repository{{ $repository->id }}" id="repository{{ $repository->id }}">
        <div class="flex-shrink-0">
          <a href="{{ route('users.show', [$repository->user_id]) }}">
            <img class="media-object img-thumbnail mr-3" alt="{{ $repository->user->name }}" src="{{ $repository->user->avatar }}" style="width:48px;height:48px;" />
          </a>
        </div>

        <div class="flex-grow-1 ms-2">
          <div class="media-heading mt-0 mb-1 text-secondary">
            <a class=" text-decoration-none" href="{{ route('users.show', [$repository->user_id]) }}" title="{{ $repository->user->name }}">
              {{ $repository->user->name }}
            </a>
            <span class="text-secondary"> • </span>
            <span class="meta text-secondary" title="{{ $repository->created_at }}">{{ $repository->created_at->diffForHumans() }}</span>

            {{-- 回复删除按钮 --}}
            <span class="meta float-end ">
              <a title="删除回复">
                <i class="far fa-trash-alt"></i>
              </a>
            </span>
          </div>
          <div class="repository-content text-secondary">
            {!! $repository->content !!}
          </div>
        </div>
      </li>

      @if ( ! $loop->last)
        <hr>
      @endif

    @endforeach
  </ul>
