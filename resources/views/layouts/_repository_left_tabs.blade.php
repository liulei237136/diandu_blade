 <div class="tw-flex tw-items-center">
     <a href="{{ $repository->link() }}"
         class="tw-no-underline tw-px-4 tw-py-2 tw-flex tw-items-center tw-text-black
        {{ if_route('repositories.show') ? 'tw-border-b  tw-border-b-red-500 ' : '' }}
        hover:tw-text-black hover:tw-border-b hover:tw-border-b-gray-200">
         <x-icon name="info" class="tw-hidden md:tw-block tw-w-4 tw-h-4 tw-mr-1" />
         <span class="">描述</span>
     </a>

     <a href="{{ route('repository_audio.show', ['repository' => $repository]) }}"
         class="
        {{ if_route('repository_audio.show') || if_route('repository_audio.edit')? 'tw-border-b tw-border-b-red-500': '' }}
        tw-no-underline tw-px-4 tw-py-2 tw-flex tw-items-center tw-text-black hover:tw-text-black  hover:tw-border-b hover:tw-border-b-gray-200">
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
         <span>拉取<span class="tw-text-sm tw-font-thin tw-rounded-3xl tw-px-2 tw-bg-gray-200 tw-ml-2">0</span></span>
     </a>
     @can('update', $repository)
         <a href="{{ $repository->link('repository_setting.show') }}"
             class="{{ if_route('repository_setting.show') ? 'tw-border-b tw-border-b-red-500' : '' }} tw-hidden tw-no-underline  tw-px-4 tw-py-2 sm:tw-flex tw-items-center tw-text-black hover:tw-text-black  hover:tw-border-b hover:tw-border-b-gray-200">
             <x-icon name="setting" class="tw-hidden md:tw-block tw-w-4 tw-h-4 tw-mr-1" />
             <span>设置</span>
         </a>
     @endcan
 </div>



