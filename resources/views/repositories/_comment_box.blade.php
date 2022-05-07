{{-- @include('shared._error') --}}

<div class="comment-box">
  <form action="{{ route('comments.store') }}" method="POST" accept-charset="UTF-8">
    @csrf
    <input type="hidden" name="repository_id" value="{{ $repository->id }}">
    <div class="mb-3">
      <textarea class="form-control" rows="3" placeholder="分享你的见解~" name="content"></textarea>
    </div>
    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-share mr-1"></i> 回复</button>
  </form>
</div>
<hr>
