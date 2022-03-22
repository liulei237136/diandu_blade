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
        <repository-affect :repository="{{ $repository->toJson() }}"
            :user="{{ auth()->user()? auth()->user()->toJson(): null }}">
        </repository-affect>
    </div>

    @if ($repository->parent)
        <div class="tw-text-sm tw-space-x-1">
            克隆于
            <a href=" {{ route('users.show', $repository->parent->user->id) }}"
                class="hover:tw-underline tw-no-underline">{{ $repository->parent->user->name }}</a>
            <span class="tw-text-black ">/</span>
            <a href="{{ route('repositories.show', $repository->parent->id) }}"
                class="hover:tw-underline tw-no-underline">{{ $repository->parent->name }}
            </a>
        </div>
    @endif

    <div class="tw-flex tw-justify-between tw-items-center tw-mt-4 tw-text-lg">
        {{-- left --}}
        @include('layouts._repository_left_tabs')
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
