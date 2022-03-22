<template>
  <div class="tw-inline-flex tw-items-center tw-space-x-4">
    <div class="tw-inline-flex tw-shadow-sm tw-rounded-md" role="group">
      <button
        @click="toggleStar"
        type="button"
        class="tw-rounded-l-lg tw-border tw-border-gray-200 tw-bg-white tw-text-sm tw-font-medium tw-px-4 tw-py-1 tw-text-gray-900 hover:tw-bg-gray-100 focus:tw-z-10 tw-inline-flex tw-items-center"
      >
        <Icon
          :name="user && isStared ? 'solid-star' : 'empty-star'"
          class="tw-w-4 tw-h-4 tw-mr-1"
        ></Icon>
        <span>{{ user && isStared ? "取消收藏" : "收藏" }}</span>
        <span
          class="tw-rounded-lg tw-border tw-border-gray-200 tw-bg-gray-100 tw-text-sm tw-font-medium tw-px-1 tw-ml-2 tw-text-gray-900 focus:tw-z-10"
        >
          {{ starCount }}
        </span>
      </button>
    </div>

    <div class="tw-inline-flex tw-shadow-sm tw-rounded-md" role="group">
      <button
        @click="onClone"
        :class="{
          buttonGroupLeftButton: !myRepository,
          buttonGroupLeftButtonDisabled: myRepository,
        }"
        :title="myRepository ? '不能克隆自己的项目' : ''"
        :disabled="myRepository"
      >
        <Icon class="tw-w-4 tw-h-4 tw-mr-1" name="clone"></Icon>
        <span>克隆</span>
      </button>
      <span class="buttonGroupRightSpan">
        {{ cloneCount }}
      </span>
    </div>
  </div>
</template>

<script>
import Icon from "./Icon.vue";

export default {
  props: {
    repository: Object,
    user: Object,
  },

  components: {
    Icon,
  },

  mounted() {
    console.log(this.repository);
    console.log(this.user);
  },
  data() {
    return {
      starCount: this.repository.star_count,
      isStared: this.repository.is_stared,
      cloneCount: this.repository.clone_count,
      hasCloned: this.repository.hasCloned,
      hasClonedRepository: this.repository.hasClonedRepository,
    };
  },
  computed: {
    myRepository() {
      return this.user && this.user.id === this.repository.user.id;
    },
    // pullCountString() {
    //   if (this.repository?.openPullsCount)
    //     return this.repository.openPullsCount;
    //   return "";
    // },
  },
  methods: {
    toggleStar() {
      //如果用户已经登录，用axios比较好
      if (this.user) {
        if (this.isStared) {
          axios.delete(route("repository-stars.destroy", this.repository.id));
          this.starCount--;
          this.isStared = false;
        } else {
          axios.post(route("repository-stars.store", this.repository.id));
          this.starCount++;
          this.isStared = true;
        }
      } else {
        window.location.href = `${route("login")}?returnTo=${encodeURI(location.href)}`;
      }
    },
    onClone() {
      if (this.hasCloned) {
        window.location.href = route(
          "repositories.show",
          this.repository.hasClonedRepository.id
        );
      } else {
        axios
          .post(route("clone-repositories.store", { repository: this.repository.id }))
          .then(function (res) {
            console.log(res.data);
            if (res.data.success) {
              window.location.href = route(
                "repositories.show",
                res.data.data,
              );
            }
          })
          .catch(function (e) {
            console.log(e.message);
          });
      }
    },
  },
};
</script>
