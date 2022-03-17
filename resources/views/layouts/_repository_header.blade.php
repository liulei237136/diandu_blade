<div class="px-3 pt-2 tw-b-bottom-gray-200 tw-border-b">
    <div class="tw-flex tw-flex-wrap  tw-items-center tw-justify-between">
        <div class="tw-flex tw-flex-wrap tw-items-center tw-space-x-1 tw-text-blue-500 tw-text-xl ">
            <a href="{{ route('users.show', $repository->user_id) }}" class=" tw-no-underline hover:tw-underline">
                {{ $repository->user->name }}
            </a>
            <span class="tw-text-black">/</span>
            <a href="{{ $repository->link() }}" class="tw-no-underline hover:tw-underline">
                {{ $repository->name }}
        </div>
        </a>
        {{-- 收藏 --}}
        <repository-affect :repository="{{$repository->toJson()}}" :user="{{auth()->user() ? auth()->user()->toJson() : null }}">
        </repository-affect>
        {{-- <div v-scope="{
            loggedIn: @json(auth()->check()),
            isStared: @json($repository->isStaredBy(auth()->user())),
            stars_count: @json($repository->stars_count),
            toggleStar(){
                if(this.isStared){
                    axios.delete(" {{ route('repository-stars.destroy', $repository->id) }}"); this.stars_count--;
                    this.isStared=false; }else{ axios.post("{{ route('repository-stars.store', $repository->id) }}");
                    this.stars_count++; this.isStared=true;
                } } }"
             class="d-flex align-items-center ">
            <div class="btn-group me-3" style="height:2.3em;font-size:0.8em" role="group" aria-label="收藏">
                <button type="button" v-if="loggedIn"
                    class="tw-inline-flex tw-items-center tw-text-gray-700 tw-px-2 tw-py-1 tw-border tw-border-gray-300 tw-rounded-lg hover:tw-bg-gray-100">
                    <x-icon v-bind:name=".isStared ? 'solid-star': 'empty-star' " class="me-1" style="width:1em" />
                    <span> @{{ isStared ? '已收藏' : '取消收藏' }}</span>
                    <span
                        class="tw-text-sm tw-font-thin tw-rounded-3xl tw-px-2 tw-bg-gray-200 tw-ml-2">@{{ stars_count }}</span>
                </button>
                <button type="button" v-else
                    class="tw-inline-flex tw-items-center tw-text-gray-700 tw-px-2 tw-py-1 tw-border tw-border-gray-300 tw-rounded-lg hover:tw-bg-gray-100">
                    <x-icon name="empty-star" class="me-1" style="width:1em" /><span>收藏</span>
                    <span
                        class="tw-text-sm tw-font-thin tw-rounded-3xl tw-px-2 tw-bg-gray-200 tw-ml-2">@{{ stars_count }}</span>
                </button>
            </div>
            <div class="btn-group" role="group" style="height:2.3em;font-size:0.8em" aria-label="克隆">
                <button type="button" class="btn btn-outline-secondary  btn-sm"><i class="far fa-code-fork me-2"></i>克隆</button>
                <button type="button" class="d-flex align-items-center btn btn-outline-secondary  btn-sm">
                    <x-icon name="fork" class="me-1" style=" width:1em" /><span>克隆</span>
                </button>
                <button type="button" class="btn btn-outline-secondary  btn-sm">0</button>
            </div>
        </div> --}}
    </div>


    <div class="tw-flex tw-justify-between tw-items-center tw-mt-4 tw-text-lg">
        {{-- left --}}
        <div class="tw-flex tw-items-center">
            <a href="{{ $repository->link() }}"
                class="tw-no-underline tw-px-4 tw-py-2 tw-flex tw-items-center tw-text-black {{ if_route('repositories.show') ? 'tw-border-b tw-border-b-red-500' : '' }} hover:tw-text-black hover:tw-border-b hover:tw-border-b-gray-200">
                <x-icon name="info" class="tw-hidden md:tw-block tw-w-4 tw-h-4 tw-mr-1" />
                <span class="">描述</span>
            </a>

            <a href="{{ route('repository_audio.show', ['repository' => $repository]) }}"
                class="tw-no-underline tw-px-4 tw-py-2 tw-flex tw-items-center tw-text-black hover:tw-text-black  hover:tw-border-b hover:tw-border-b-gray-200">
                <x-icon name="audio" class="tw-hidden md:tw-block tw-w-4 tw-h-4 tw-mr-1" />
                <span>包含音频</span>
            </a>
            <a href="{{ $repository->link('repository_comments.show') }}"
                class="{{ if_route('repository_comments.show') ? 'tw-border-b tw-border-b-red-500' : '' }} tw-no-underline  tw-px-4 tw-py-2 tw-flex tw-items-center tw-text-black hover:tw-text-black  hover:tw-border-b hover:tw-border-b-gray-200">
                <i class="fa-regular fa-comment tw-hidden md:tw-block tw-w-4 tw-h-4 tw-mr-1"></i>
                <span>评论<span
                        class="tw-text-sm tw-font-thin tw-rounded-3xl tw-px-2 tw-bg-gray-200 tw-ml-2">{{ $repository->comment_count }}</span></span>
            </a>
            <a href="#"
                class="tw-hidden tw-no-underline  tw-px-4 tw-py-2 sm:tw-flex tw-items-center tw-text-black hover:tw-text-black  hover:tw-border-b hover:tw-border-b-gray-200">
                <x-icon name="pull" class="tw-hidden md:tw-block tw-w-4 tw-h-4 tw-mr-1" />
                <span>拉取<span
                        class="tw-text-sm tw-font-thin tw-rounded-3xl tw-px-2 tw-bg-gray-200 tw-ml-2">0</span></span>
            </a>
            @can('update', $repository)
                <a href="{{ $repository->link('repository_setting.show') }}"
                    class="{{ if_route('repository_setting.show') ? 'tw-border-b tw-border-b-red-500' : '' }} tw-hidden tw-no-underline  tw-px-4 tw-py-2 sm:tw-flex tw-items-center tw-text-black hover:tw-text-black  hover:tw-border-b hover:tw-border-b-gray-200">
                    <x-icon name="setting" class="tw-hidden md:tw-block tw-w-4 tw-h-4 tw-mr-1" />
                    <span>设置</span>
                </a>
            @endcan
        </div>
        {{-- right --}}
        <div class="sm:tw-hidden">
            <div class="dropdown">
                {{-- <button class="btn btn-secondary dropdown-toggle btn-sm " type="button" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                </button> --}}
                <button class="" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16">
                        <path
                            d="M8 9a1.5 1.5 0 100-3 1.5 1.5 0 000 3zM1.5 9a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm13 0a1.5 1.5 0 100-3 1.5 1.5 0 000 3z">
                        </path>
                    </svg>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="#">拉取<span
                                class="tw-text-sm tw-font-thin tw-rounded-3xl tw-px-2 tw-bg-gray-200 tw-ml-2">0</span></a>
                    </li>
                    @can('update', $repository)
                        <li><a class="dropdown-item" href="{{ $repository->link('repository_setting.show') }}">设置</a>
                        </li>
                    @endcan
                </ul>
            </div>
        </div>
    </div>
</div>
