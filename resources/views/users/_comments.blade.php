@if (count($comments))

  <ul class="list-group mt-4 border-0">
    @foreach ($comments as $comment)
      <li class="list-group-item ps-2 pe-2 border-end-0 border-start-0 @if($loop->first) border-top-0 @endif">
        <a class="text-decoration-none" href="{{ $comment->repository->link('repository_comments.show',['#comment' . $comment->id]) }}">
          {{ $comment->repository->name }}
        </a>

        <div class="comment-content text-secondary mt-2 mb-2">
          {!! $comment->content !!}
        </div>

        <div class="text-secondary" style="font-size:0.9em;">
          <i class="far fa-clock"></i> 评论于 {{ $comment->created_at->diffForHumans() }}
        </div>
      </li>
    @endforeach
  </ul>

@else
  <div class="empty-block">暂无数据 ~_~ </div>
@endif

{{-- 分页 --}}
<div class="mt-4 pt-1">
  {!! $comments->appends(request()->except('page'))->render() !!}
</div>
