<template>
  <div class="inline-flex items-center space-x-4">
    <div class="inline-flex shadow-sm rounded-md" role="group">
      <button @click="toggleStar" class="buttonGroupLeftButton">
        <Icon
          :name="props.user && isStared ? 'solid-star' : 'empty-star'"
          class="w-4 h-4 mr-1"
        ></Icon>
        <span>{{ props.user && isStared ? "取消收藏" : "收藏" }}</span>
      </button>
      <span class="buttonGroupRightSpan">
        {{ starsCount }}
      </span>
    </div>
    <div class="inline-flex shadow-sm rounded-md" role="group">
      <button
        @click="onClone"
        :class="{
          buttonGroupLeftButton: !myRepository,
          buttonGroupLeftButtonDisabled: myRepository,
        }"
        :title="myRepository ? '不能克隆自己的项目' : ''"
        :disabled="myRepository"
      >
        <Icon class="w-4 h-4 mr-1" name="clone"></Icon>
        <span>克隆</span>
      </button>
      <span class="buttonGroupRightSpan">
        {{ clonesCount }}
      </span>
    </div>
  </div>
</template>

<script>
import Icon from "./Icon.vue";

export default {
  props: {
      repository: Object,

  },

  components: {
    Icon,
  },

  data() {
    return {
      starsCount: this.props.repository.favorites_count,
      isStared: this.props.repository.stared,
      clonesCount: this.props.repository.clones_count,
      hasCloned: this.props.repository.hasCloned,
      hasClonedRepository: this.props.repository.hasClonedRepository,
      componentName: this.component,
    };
  },
  computed: {
    myRepository() {
      return this.props.user && this.props.user.id === this.repository.user.id;
    },
    pullCountString() {
      if (this.props.repository?.openPullsCount)
        return this.props.repository.openPullsCount;
      return "";
    },
  },
  methods: {
    toggleStar() {
      //如果用户已经登录，用axios比较好
      if (this.props.user) {
        if (this.isStared) {
          axios.delete(route("star-repositorys.destroy", { repository: this.repository.id }));
          this.starsCount--;
          this.isStared = false;
        } else {
          axios.post(route("star-repositorys.store", { repository: this.repository.id }));
          this.starsCount++;
          this.isStared = true;
        }
      } else {
        //如果没登录，才用inertia实现登录后跳转
        this.$inertia.post(route("star-repositorys.store", { repository: this.repository.id }));
      }
    },
    onClone() {
      if (this.hasCloned) {
        this.$inertia.get(
          route("repository.show", { repository: this.repository.hasClonedRepository.id })
        );
      } else {
        this.$inertia.post(route("clone-repositorys.store", { repository: this.repository.id }));
      }
    },
  },
};
</script>
