<div class="card ">
    <div class="card-body tw-flex">
      <a href="{{ route('repositories.create') }}" class="btn btn-success tw-w-full" aria-label="Left Align">
        <i class="fas fa-pencil-alt mr-2"></i> 新建仓库
      </a>
    </div>
  </div>

  @if (count($active_users))
    <div class="card mt-4">
      <div class="card-body active-users pt-2">
        <div class="text-center mt-1 mb-0 text-muted">活跃用户</div>
        <hr class="mt-2">
        @foreach ($active_users as $active_user)
          <a class="tw-flex tw-items-center tw-mt-2 tw-no-underline" href="{{ route('users.show', $active_user->id) }}">
            <div class="tw-shrink-0 tw-mr-2 tw-ml-1">
              <img src="{{ $active_user->avatar }}" width="24" height="24" class="tw-object-cover">
            </div>
            <div class="">
              <small class=" text-secondary">{{ $active_user->name }}</small>
            </div>
          </a>
        @endforeach
      </div>
    </div>
  @endif

  {{-- @if (count($links))
    <div class="card mt-4">
      <div class="card-body pt-2">
        <div class="text-center mt-1 mb-0 text-muted">资源推荐</div>
        <hr class="mt-2 mb-3">
        @foreach ($links as $link)
          <a class="media mt-1" href="{{ $link->link }}">
            <div class="media-body">
              <span class="media-heading text-muted">{{ $link->title }}</span>
            </div>
          </a>
        @endforeach
      </div>
    </div>
  @endif --}}
