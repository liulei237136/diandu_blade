<div class="px-3 py-2">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <a href="#">
            {{ $repository->user->name }}
            </a>
            /
            <a href="#">
            {{ $repository->name }}</div>
            </a>
        <div class="d-flex align-items-center ">
            <div class="btn-group me-3 " style="height:2.3em;font-size:0.8em"  role="group" aria-label="收藏">
                <button type="button" class="d-flex align-items-center btn btn-outline-secondary btn-sm "><x-icon name="empty-star" class="me-1" style="width:1em" /><span>收藏</span></button>
                <button type="button" class="btn btn-outline-secondary btn-sm">0</button>
            </div>
            <div class="btn-group" role="group" style="height:2.3em;font-size:0.8em"  aria-label="克隆">
                {{-- <button type="button" class="btn btn-outline-secondary  btn-sm"><i class="far fa-code-fork me-2"></i>克隆</button> --}}
                <button type="button" class="d-flex align-items-center btn btn-outline-secondary  btn-sm"><x-icon name="fork" class="me-1" style=" width:1em"/><span>克隆</span></button>
                <button type="button" class="btn btn-outline-secondary  btn-sm">0</button>
            </div>
        </div>
    </div>

</div>
