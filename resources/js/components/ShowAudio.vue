<template>
  <vxe-grid ref="xGrid" v-bind="gridOptions" v-on="gridEvents">
    <template #toolbar_buttons>
      <vxe-pulldown ref="xDown" class="tw-mr-4">
        <template #default>
          <vxe-input
            v-model="demo.filterCommitTitle"
            :placeholder="commit ? commit.title : '还没有保存过'"
            @focus="commitFocusEvent"
            @keyup="commitKeyupEvent"
          ></vxe-input>
        </template>
        <template #dropdown>
          <div class="my-dropdown" v-if="demo.filteredCommitsList.length > 0">
            <div
              class="list-item"
              v-for="commit in demo.filteredCommitsList"
              :key="commit.id"
            >
              <a
                :href="
                  route('repository_audio.show', {
                    repository: commit.repository_id,
                    commit: commit.id,
                  })
                "
                :title="commit.title"
                >{{ commit.title }}</a
              >
            </div>
          </div>
        </template>
      </vxe-pulldown>
      <!-- 编辑 -->
      <!-- <vxe-button content="编辑" @click="onSave"></vxe-button> -->
      <a
        v-if="canEdit"
        class="btn btn-primary btn-sm"
        >编辑</a>
    </template>

    <template #source_audio="{ row }">
      <audio
        v-if="row.file_path"
        :src="row.file_path"
        @play="onAudioPlayEvent($event, row)"
        controls
      ></audio>
    </template>
  </vxe-grid>
</template>

<style scoped>
.my-dropdown {
  padding: 4px;
  height: auto;
  max-height: 300px;
  min-width: 300px;
  max-width: 600px;
  overflow-y: auto;
  border-radius: 4px;
  border: 1px solid #dcdfe6;
  background-color: #fff;
}
.list-item {
  padding: 2px;
  line-height: 22px;
  font-size: 16px;
}
.list-item:hover {
  background-color: #f5f7fa;
}
</style>

<script>
import { defineComponent, reactive, ref } from "vue";
import { getCommitAudio, filterStringMethod, nameSortBy } from "../helper.js";

export default defineComponent({
  props: {
    repository: Object,
    commit: Object,
    canEdit: Boolean,
  },
  mounted() {
    console.log("this.repository");
    console.log(this.repository);
    console.log('canEdit', this.canEdit);
  },
  setup(props, context) {
    const xGrid = ref({});

    const xDown = ref({});

    const demo = reactive({
      filterAllString: "",
      audioList: [],
      filterCommitTitle: "",
      filteredCommitsList: props.repository.commits,
      playingAudio: {},
    });

    const onAudioPlayEvent = (e) => {
      const { audio } = demo.playingAudio;
      if (audio && audio !== e.target) {
        audio.pause();
        // audio.fastSeek(0);
      }
      demo.playingAudio = { audio: e.target };
    };

    const commitFocusEvent = () => {
      const $pulldown = xDown.value;
      $pulldown.showPanel();
    };

    const commitKeyupEvent = () => {
      demo.filteredCommitsList = demo.filterCommitTitle
        ? props.commits.filter(
            (commit) => commit.title.indexOf(demo.filterCommitTitle) > -1
          )
        : props.commits;
    };

    const gridOptions = reactive({
      // loading:false,
      border: true,
      resizable: true,
      showHeaderOverflow: true,
      showOverflow: true,
      highlightHoverRow: true,
      id: "full_edit_1",
      height: 600,
      rowId: "id",
      customConfig: {
        storage: true,
      },
      printConfig: {},
      sortConfig: {
        trigger: "cell",
      },
      filterConfig: {},

      toolbarConfig: {
        slots: {
          buttons: "toolbar_buttons",
        },
        // tools: [{ code: "myExport", name: "导出" }],
        zoom: true,
        // custom: true,
      },

      columns: [
        { type: "checkbox", width: 40 },
        { type: "seq", width: 60 },
        {
          field: "file_name",
          title: "音频文件名",
          width: 200,
          sortable: true,
          sortBy: nameSortBy,
          titleHelp: { message: "注意要加上文件后缀" },
          filters: [{ data: "" }],
          filterMethod: filterStringMethod,
          filterConfig: {},
          filterRender: { name: "$input" },
        },
        {
          title: "音频",
          width: 300,
          slots: {
            default: "source_audio",
          },
        },
        {
          field: "comment",
          title: "备注",
          titleHelp: { message: "用于过滤和查找" },
          filters: [{ data: "" }],
          filterMethod: filterStringMethod,
          filterConfig: {},
          filterRender: { name: "$input" },
        },
      ],
      proxyConfig: {
        ajax: {
          // 当点击工具栏查询按钮或者手动提交指令 query或reload 时会被触发
          query: async ({ page, sorts, filters, form }) => {
            demo.audioList = await getCommitAudio(props.commit);
            resetAll();
            return demo.audioList;
          },
        },
      },
      checkboxConfig: {
        highlight: true,
        range: true,
      },
    });

    const resetAll = () => {
      console.log("reset all");
    };

    // const gridEvents = {
    //   toolbarToolClick({ code }) {
    //     const $grid = xGrid.value;
    //     switch (code) {
    //       case "myExport":
    //         $grid.exportData({
    //           type: "csv",
    //           mode: "all", //	current, selected, all
    //           original: true,
    //           columns: [
    //             { field: "file_name" },
    //             { field: "file_path" },
    //             { field: "comment" },
    //             { field: "book_name" },
    //           ],
    //         });
    //     }
    //   },
    // };

    return {
      xGrid,
      xDown,
      gridOptions,
      demo,
      getCommitAudio,
      resetAll,
      filterStringMethod,
      //   gridEvents,
      commitFocusEvent,
      commitKeyupEvent,
      onAudioPlayEvent,
    };
  },
});
</script>
