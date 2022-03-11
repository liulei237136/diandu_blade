<div class="px-3 pt-2 tw-b-bottom-gray-200 tw-border-b">
    <div class="tw-flex tw-flex-wrap  tw-items-center tw-justify-between">
        <div class="tw-flex tw-flex-wrap tw-items-center tw-space-x-1 tw-text-blue-500 tw-text-xl ">
            <a href="{{route('users.show', $repository->user_id)}}" class=" tw-no-underline hover:tw-underline">
                {{ $repository->user->name }}
            </a>
            <span class="tw-text-black">/</span>
            <a href="{{$repository->link()}}" class="tw-no-underline hover:tw-underline">
                {{ $repository->name }}
        </div>
        </a>
        <div class="d-flex align-items-center ">
            <div class="btn-group me-3 " style="height:2.3em;font-size:0.8em" role="group" aria-label="收藏">
                <button type="button" class="d-flex align-items-center btn btn-outline-secondary btn-sm ">
                    <x-icon name="empty-star" class="me-1" style="width:1em" /><span>收藏</span>
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm">0</button>
            </div>
            <div class="btn-group" role="group" style="height:2.3em;font-size:0.8em" aria-label="克隆">
                {{-- <button type="button" class="btn btn-outline-secondary  btn-sm"><i class="far fa-code-fork me-2"></i>克隆</button> --}}
                <button type="button" class="d-flex align-items-center btn btn-outline-secondary  btn-sm">
                    <x-icon name="fork" class="me-1" style=" width:1em" /><span>克隆</span>
                </button>
                <button type="button" class="btn btn-outline-secondary  btn-sm">0</button>
            </div>
        </div>
    </div>


    <div class="tw-flex tw-items-center tw-mt-4 tw-text-lg">
        <a href="{{$repository->link()}}"
            class="tw-no-underline tw-px-4 tw-py-2 tw-flex tw-items-center tw-text-black {{ if_route('repositories.show') ? 'tw-border-b tw-border-b-red-500' : '' }} hover:tw-text-black hover:tw-border-b hover:tw-border-b-gray-200">
            <x-icon name="info" class="tw-hidden md:tw-block tw-w-4 tw-h-4 tw-mr-1" />
            <span class="">基本信息</span>
        </a>

        <a href="#"
            class="tw-no-underline tw-px-4 tw-py-2 tw-flex tw-items-center tw-text-black hover:tw-text-black  hover:tw-border-b hover:tw-border-b-gray-200">
            <x-icon name="audio" class="tw-hidden md:tw-block tw-w-4 tw-h-4 tw-mr-1" />
            <span>包含音频</span>
        </a>
        <a href="#"
            class="tw-no-underline  tw-px-4 tw-py-2 tw-flex tw-items-center tw-text-black hover:tw-text-black  hover:tw-border-b hover:tw-border-b-gray-200">
            <x-icon name="pull" class="tw-hidden md:tw-block tw-w-4 tw-h-4 tw-mr-1" />
            <span>拉取<span class="tw-text-sm tw-font-thin tw-rounded-3xl tw-px-2 tw-bg-gray-200 tw-ml-2">0</span></span>
        </a>
        <a href="{{$repository->link('repository_comments.show')}}"
            class="{{ if_route('repository_comments.show') ? 'tw-border-b tw-border-b-red-500' : '' }} tw-no-underline  tw-px-4 tw-py-2 tw-flex tw-items-center tw-text-black hover:tw-text-black  hover:tw-border-b hover:tw-border-b-gray-200">
            {{-- <x-icon name="setting" class="tw-hidden md:tw-block tw-w-4 tw-h-4 tw-mr-1" /> --}}
            <i class="fa-regular fa-comment tw-hidden md:tw-block tw-w-4 tw-h-4 tw-mr-1" ></i>
            <span>评论<span class="tw-text-sm tw-font-thin tw-rounded-3xl tw-px-2 tw-bg-gray-200 tw-ml-2">{{$repository->comment_count}}</span></span>
        </a>
        @can('update', $repository)
        <a href="{{$repository->link('repository_setting.show')}}"
            class="{{ if_route('repository_setting.show') ? 'tw-border-b tw-border-b-red-500' : '' }} tw-no-underline  tw-px-4 tw-py-2 tw-flex tw-items-center tw-text-black hover:tw-text-black  hover:tw-border-b hover:tw-border-b-gray-200">
            <x-icon name="setting" class="tw-hidden md:tw-block tw-w-4 tw-h-4 tw-mr-1" />
            <span>设置</span>
        </a>
        @endcan
    </div>




</div>
{{-- <div class="flex item-center justify-between">
    <package-link :package="package" classes="text-lg"></package-link>

    <div class="inline-flex items-center space-x-4">
      <div class="inline-flex shadow-sm rounded-md" role="group">
        <button @click="toggleStar" class="buttonGroupLeftButton">
          <Icon
            :name="$page.props.user && isStared ? 'solid-star' : 'empty-star'"
            class="w-4 h-4 mr-1"
          ></Icon>
          <span>{{ $page.props.user && isStared ? "取消收藏" : "收藏" }}</span>
        </button>
        <span class="buttonGroupRightSpan">
          {{ starsCount }}
        </span>
      </div>
      <div class="inline-flex shadow-sm rounded-md" role="group">
        <button
          @click="onClone"
          :class="{
            buttonGroupLeftButton: !myPackage,
            buttonGroupLeftButtonDisabled: myPackage,
          }"
          :title="myPackage ? '不能克隆自己的项目' : ''"
          :disabled="myPackage"
        >
          <Icon class="w-4 h-4 mr-1" name="clone"></Icon>
          <span>克隆</span>
        </button>
        <span class="buttonGroupRightSpan">
          {{ clonesCount }}
        </span>
      </div>
    </div>
  </div>
  <!-- 显示forkfrom行 -->
  <div v-if="package.parent" class="text-xs">
    克隆于
    <package-link :package="package.parent" classes="text-sm"></package-link>
  </div>
  <!-- tabs -->
  <div class="flex items-center space-x-2 mt-4 text-lg content-tab">
    <Link
      :href="route('package.show', { package: this.package.id })"
      class="px-4 py-2 flex items-center"
      :class="{
        active:
          componentName === 'Package/ShowBasicInfo' ||
          componentName === 'Package/EditBasicInfo',
      }"
    >
      <Icon name="info" class="d-none sm:inline w-5 h-5 mr-1"></Icon>
      <span>基本信息</span></Link
    >
    <Link
      :href="route('package.audio', { package: this.package.id })"
      class="px-4 py-2 flex items-center"
      :class="{
        active:
          componentName === 'Package/ShowAudio' ||
          componentName === 'Package/EditAudio',
      }"
    >
      <Icon name="audio" class="d-none sm:inline w-5 h-5 mr-1"></Icon>
      <span>包含音频</span></Link
    >
    <Link
      :href="route('package.pulls', { package: this.package.id })"
      class="px-4 py-2 flex items-center"
      :class="{
        active: componentName === 'Package/ShowPulls',
      }"
    >
      <Icon name="pull" class="d-none sm:inline w-5 h-5 mr-1"></Icon>
      <span>拉取</span>
      <span class="text-sm font-thin rounded-3xl px-2 bg-gray-200 ml-2">{{pullCountString}}</span>
    </Link>
  </div>
</header> --}}
