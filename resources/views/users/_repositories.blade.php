@if (count($repositories))

  <ul class="list-group mt-4 border-0">
    @foreach ($repositories as $repository)
      <li class="list-group-item ps-2 pe-2 border-end-0 border-start-0 @if($loop->first) border-top-0 @endif">
        <a class="text-decoration-none" href="{{$repository->link()}}">
          {{ $repository->name }}
        </a>
        <span class="meta float-end text-secondary">
          {{-- {{ $repository->reply_count }} 回复
          <span> ⋅ </span> --}}
          {{ $repository->created_at->diffForHumans() }}
        </span>
      </li>
    @endforeach
  </ul>

@else
  <div class="empty-block">暂无数据 ~_~ </div>
@endif

{{-- 分页 --}}
<div class="mt-4 pt-1">
  {!! $repositories->render() !!}
</div>

