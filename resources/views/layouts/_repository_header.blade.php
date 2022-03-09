<div class="px-3 py-2">
    <div class="d-flex align-items-center justify-content-between">
        <div>{{ $repository->user->name }}/{{ $repository->name }}</div>
        <div class="d-flex align-items-center ">
            <div class="btn-group me-3 " role="group" aria-label="收藏">
                <button type="button" class="btn btn-outline-secondary btn-sm "><i class="fa-regular fa-star me-2"></i>收藏</button>
                <button type="button" class="btn btn-outline-secondary btn-sm">0</button>
            </div>
            <div class="btn-group" role="group" aria-label="克隆">
                <button type="button" class="btn btn-outline-secondary  btn-sm"><i class="fa-light fa-code-fork me-2"></i>克隆</button>
                <button type="button" class="btn btn-outline-secondary  btn-sm">0</button>
            </div>
        </div>
    </div>

</div>
