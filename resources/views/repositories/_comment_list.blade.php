<ul class="list-unstyled">
    @foreach ($comments as $index => $comment)
        <li class="d-flex" name="comment{{ $comment->id }}" id="comment{{ $comment->id }}">
            <div class="flex-shrink-0">
                <a href="{{ route('users.show', [$comment->user_id]) }}">
                    <img class="media-object img-thumbnail mr-3" alt="{{ $comment->user->name }}"
                        src="{{ $comment->user->avatar }}" style="width:48px;height:48px;" />
                </a>
            </div>

            <div class="flex-grow-1 ms-2">
                <div class="media-heading mt-0 mb-1 text-secondary">
                    <a class=" text-decoration-none" href="{{ route('users.show', [$comment->user_id]) }}"
                        title="{{ $comment->user->name }}">
                        {{ $comment->user->name }}
                    </a>
                    <span class="text-secondary"> • </span>
                    <span class="meta text-secondary"
                        title="{{ $comment->created_at }}">{{ $comment->created_at->diffForHumans() }}</span>

                    {{-- 回复删除按钮
                    <span class="meta float-end ">
                        <a title="删除回复">
                            <i class="far fa-trash-alt"></i>
                        </a>
                    </span> --}}
                    {{-- 回复删除按钮 --}}
                    @can('destroy', $comment)
                        <span class="float-end">
                            <form action="{{ route('comments.destroy', $comment->id) }}"
                                onsubmit="return confirm('确定要删除此评论？');" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-default btn-xs pull-left text-secondary">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </form>
                        </span>
                    @endcan
                </div>
                <div class="comment-content text-secondary">
                    {!! $comment->content !!}
                </div>
            </div>
        </li>

        @if (!$loop->last)
            <hr>
        @endif
    @endforeach
</ul>
