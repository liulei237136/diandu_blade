<template>
  <vxe-modal
    v-model="demo.showSaveModal"
    id="saveModal"
    width="800"
    height="360"
    min-width="460"
    min-height="320"
    show-zoom
    resize
    storage
    transfer
  >
    <template #title>
      <span>给本次保存起个名字</span>
    </template>
    <template #default>
      <vxe-form
        title-colon
        ref="saveForm"
        title-align="right"
        title-width="100"
        :data="demo.saveFormData"
        :rules="demo.saveFormRules"
        :loading="demo.saveFormloading"
        @submit="saveModalFormSubmitEvent"
      >
        <vxe-form-item title="名字" field="title" span="18" :item-render="{}">
          <template #default="{ data }">
            <vxe-input
              @change="saveForm.clearValidate('title')"
              v-model="data.title"
              placeholder=""
              clearable
            ></vxe-input>
          </template>
        </vxe-form-item>
        <vxe-form-item title="描述" field="description" span="24" :item-render="{}">
          <template #default="{ data }">
            <vxe-textarea
              v-model="data.description"
              @change="saveForm.clearValidate('description')"
              placeholder=""
              :autosize="{ minRows: 6, maxRows: 10 }"
              clearable
            ></vxe-textarea>
          </template>
        </vxe-form-item>
        <vxe-form-item align="center" span="24">
          <template #default>
            <vxe-button
              :disabled="demo.saveFormLoading"
              type="submit"
              status="primary"
              content="提交"
            ></vxe-button>
          </template>
        </vxe-form-item>
      </vxe-form>
    </template>
  </vxe-modal>

  <vxe-grid ref="xGrid" v-bind="gridOptions">
    <template #toolbar_buttons>
      <vxe-pulldown ref="xDown" class="mr-4">
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
                class="tw-text-black tw-no-underline tw-block"
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
      <!-- 保存 -->
      <vxe-button content="保存" @click="onSave"></vxe-button>
      <!-- 插入 -->
      <vxe-button content="插入">
        <template #dropdowns>
          <vxe-button
            type="text"
            @click="insertEmptyAt(0)"
            content="在第一行插入空行"
          ></vxe-button>
          <vxe-button
            type="text"
            @click="insertEmptyAt(-1)"
            content="在最后一行插入空行"
          ></vxe-button>
          <vxe-button
            type="text"
            @click="insertEmptyBeforeSelected()"
            content="选中行前插入空行"
          ></vxe-button>
          <vxe-button
            type="text"
            @click="insertAudioAt(0)"
            content="在第一行插入音频"
          ></vxe-button>
          <vxe-button
            type="text"
            @click="insertAudioAt(-1)"
            content="在最后一行插入音频"
          ></vxe-button>
          <vxe-button
            type="text"
            @click="insertAudioBeforeSelected()"
            content="选中行前插入音频"
          ></vxe-button>
        </template>
      </vxe-button>
      <!-- 删除 -->
      <vxe-button content="删除选中" @click="xGrid.removeCheckboxRow"></vxe-button>
      <vxe-button content="下载">
        <template #dropdowns>
          <vxe-button
            title="本次插入音频和本次录音不会被下载"
            content="下载本次保存的所有音频为一个压缩文件"
            @click="onDownloadAllAudio"
          ></vxe-button>
          <vxe-button
            @click="onDownloadCheckedAudio"
            content='下载选中的音频  (优先级 "本次录音">"本次插入音频">"前次已保存音频")'
          ></vxe-button>
        </template>
      </vxe-button>
    </template>

    <template #source_audio="{ row }">
      <audio
        class="h-6"
        v-if="row.file_path"
        :src="row.file_path"
        @play="onAudioPlayEvent($event, row)"
        controls
        preload="metadata"
      ></audio>
    </template>
    <template #local_audio="{ row }">
      <audio
        class="h-6"
        v-if="row.localUrl"
        :src="row.localUrl"
        @play="onAudioPlayEvent($event, row)"
        controls
        preload="metadata"
      ></audio>
    </template>
    <template #record_audio="{ row }">
      <div class="flex items-center">
        <div>
          <audio-recorder :row="row" :demo="demo" class="mr-1"></audio-recorder>
        </div>
        <div>
          <audio
            class="h-6"
            v-if="row.recordUrl"
            :src="row.recordUrl"
            @play="onAudioPlayEvent($event, row)"
            controls
        preload="metadata"
          ></audio>
        </div>
      </div>
    </template>
  </vxe-grid>
</template>

<style scoped>
.my-dropdown {
  padding: 4px;
  height: auto;
  max-height: 300px;
  min-width: 300px;
  max-width: 1200px;
  overflow-y: hidden;
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
import { defineComponent, nextTick, onMounted, reactive, ref } from "vue";
import { VXETable, VxeGridInstance, VxeGridProps } from "vxe-table";
import axios from "axios";
import AudioRecorder from "./AudioRecorder.vue";
import PlayButton from "./PlayButton.vue";
import {
  getCommitAudio,
  filterStringMethod,
  nameSortBy,
  uploadToCos,
} from "../helper.js";

export default defineComponent({
  props: {
    repository: Object,
    commit: Object,
    user: Object,
  },
  components: {
    AudioRecorder,
  },
  setup(props, context) {
    const xGrid = ref({});

    const saveForm = ref({});

    const xDown = ref({});

    const demo = reactive({
      audioToLoad: [],
      filterAllString: "",
      audioList: [],
      filterCommitTitle: "",
      filteredCommitsList: props.repository.commits,
      showSaveModal: false,
      saveFormLoading: false,
      saveFormData: {
        title: "",
        description: "",
      },
      saveFormRules: {
        title: [
          { required: true, message: "请输入本次保存的名称" },
          { min: 3, max: 256, message: "长度在 3 到 256 个字符" },
        ],
        description: [{ max: 1000, message: "长度小于1000个字符" }],
      },
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

    const onSave = async () => {
      //todo validate
      //and wheather changed ? 是否一定要有改动才保存

      if (!(await commitHasChanged())) {
        return await VXETable.modal.message({ content: "内容没有改动" });
      }
      demo.showSaveModal = true;
    };

    const saveModalFormSubmitEvent = async () => {
      // 先验证是否有错误
      const errMap = await saveForm.value.validate();
      if (errMap) return;

      demo.saveFormLoading = true;
      const { fullData } = xGrid.value.getTableData();

      //2.上传mp3,优先级 录音大于本地
      for (let record of fullData) {
        //无需上传
        if (!record.recordFile && !record.localFile) continue;
        // 优先级 audioFile > localFile
        const file = record.recordFile ? record.recordFile : record.localFile;

        try {
          const { url } = await uploadToCos('audio', file);
          record.file_path = url;
          record.user_name = props.user.name;
          record.user_id = props.user.id;
          record.created_at = Date.now();
        } catch (error) {
            console.log(error);
            alert('after uploadtocos and error');
          if (error.response) {
            // The request was made and the server responded with a status code
            // that falls out of the range of 2xx
            console.log(error.response.data);
            console.log(error.response.status);
            console.log(error.response.headers);
          } else if (error.request) {
            // The request was made but no response was received
            // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
            // http.ClientRequest in node.js
            console.log(error.request);
          } else {
            // Something happened in setting up the request that triggered an Error
            console.log("Error", error.message);
          }
        }
      }
      //3.拼装content
      let content = "file_name,file_path,comment,user_name,user_id,created_at\n";

      for (let record of fullData) {
        content += record.file_name ? record.file_name : "";
        content += ",";
        content += record.file_path ? record.file_path : "";
        content += ",";
        content += record.comment ? record.comment : "";
        content += ",";
        content += props.user.name;
        content += ",";
        content += props.user.id;
        content += ",";
        content += Date.now();
        content += "\n";
      }
      console.log(content);

      try {
        // const result = await window.axios.post(
        //   route("commits.store", props.repository.id),
        //   {
        //     title: demo.saveFormData.title,
        //     description: demo.saveFormData.description,
        //     content: content,
        //   }
        // );
        // console.log(result);
        const {url} = uploadCotentToCos('commit', content);
        console.log(url);
        alert('uplaodtocos commit success');
        const result = await window.axios.post(
          route("commits.store", props.repository.id),
          {
            title: demo.saveFormData.title,
            description: demo.saveFormData.description,
            url: url,
          }
        );
        console.log(result);


        if (result.data.success) {
          window.location.href = route("repository_audio.edit", {
            repository: props.repository.id,
            commit: result.data.commit_id,
          });
        } else {
          console.log(result.data.message);
          alert(result.data.message);
        }
      } catch (e) {
        console.log(e);
        alert(e.message);
      }
    };

    const gridOptions = reactive({
      // loading:false,
      border: true,
      resizable: true,
      showHeaderOverflow: true,
      showOverflow: true,
      highlightHoverRow: true,
      keepSource: true,
      id: "full_edit_1",
      height: 600,
      rowKey: true,
      // customConfig: {
      //   storage: true,
      // },
      //   importConfig: {
      //     mode: "covering",
      //   },
      //   printConfig: {},
      sortConfig: {
        trigger: "cell",
      },
      filterConfig: {},

      toolbarConfig: {
        slots: {
          buttons: "toolbar_buttons",
        },
        // tools: [
        //   { code: "myImport", name: "导入" },
        //   { code: "myExport", name: "导出" },
        // ],
        // save: true,
        // refresh: true,
        // print: true,
        zoom: true,
        // custom: true,
      },

      columns: [
        { type: "checkbox", width: 40 },
        { type: "seq", width: 60 },
        {
          field: "file_name",
          title: "音频文件名",
          width: 210,
        //   sortable: true,
        //   sortBy: nameSortBy,
        //   titleHelp: { message: "注意要加上文件后缀" },
          editRender: { name: "input", attrs: { placeholder: "请输入文件名" } },
          filters: [{ data: "" }],
          filterMethod: filterStringMethod,
          filterConfig: {},
          filterRender: { name: "$input" },
        },
        //for export only
        // { field: "file_path", title: "音频文件路径", visible: false },
        // { field: "file_size", title: "音频文件大小", visible: false },
        {
          title: "前次已保存音频",
          width: 210,
          slots: {
            default: "source_audio",
          },
        },
        {
          title: "本次插入音频",
          width: 210,
          slots: {
            default: "local_audio",
          },
        },
        {
          title: "本次录音",
          width: 370,
          slots: {
            default: "record_audio",
          },
        },
        {
          field: "comment",
          title: "备注",
        //   titleHelp: { message: "用于过滤和查找" },
          editRender: { name: "input", attrs: { placeholder: "请输入备注" } },
          filters: [{ data: "" }],
          filterMethod: filterStringMethod,
          filterConfig: {},
          filterRender: { name: "$input" },
        },
      ],
      rowConfig: {
        height: 35,
      },
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
      editRules: {
        file_name: [{ max: 225, message: "名称长度最长 225 个字符" }],
      },
      editConfig: {
        trigger: "click",
        mode: "row",
        showStatus: true,
      },
    });

    const insertEmptyAt = async (index) => {
      const grid = xGrid.value;
      const { row } = await grid.insertAt({}, index);
      await grid.setActiveCell(row, "file_name");
    };

    const insertEmptyBeforeSelected = async () => {
      const grid = xGrid.value;
      const selectedRows = grid.getCheckboxRecords(true);
      if (selectedRows.length === 0) {
        return VXETable.modal.message({
          content: "请选中一行",
          status: "warning",
        });
      } else if (selectedRows.length > 1) {
        return VXETable.modal.message({
          content: "勾选了多行，请只选一行",
          status: "warning",
        });
      } else {
        await insertEmptyAt(selectedRows[0]);
      }
    };

    const insertAudioAt = async (index) => {
      const grid = xGrid.value;
      const { files } = await grid.readFile({ multiple: true });
      let fileCount = files.length;
      if (fileCount === 0) return;
      let rows = [];
      for (let file of files) {
        rows.push({
          file_name: file.name,
          localFile: file,
          //   (window.URL || webkitURL).createObjectURL(blob);
          localUrl: (window.URL || webkitURL).createObjectURL(file),
        });
      }
      if (index === 0) {
        rows.reverse();
      }
      for (let j = 0; j < fileCount; j++) {
        const item = rows[j];
        const { row: currentRow } = await grid.insertAt(item, index);
        if (j === fileCount - 1) {
          //todo 根据条件选出setActiveCell row
          await grid.setActiveCell(currentRow, "file_name");
        }
      }
    };

    const insertAudioBeforeSelected = async () => {
      const grid = xGrid.value;
      const selectedRows = grid.getCheckboxRecords(true);
      if (selectedRows.length === 0) {
        return VXETable.modal.message({
          content: "请选中一行",
          status: "warning",
        });
      } else if (selectedRows.length > 1) {
        return VXETable.modal.message({
          content: "勾选了多行，请只选一行",
          status: "warning",
        });
      } else {
        await insertAudioAt(selectedRows[0]);
      }
    };

    const resetAll = () => {
      //   console.log("reset all");
    };
    const onDownloadAllAudio = async () => {
      if (props.commit) {
        location.href = route("commit-download-all-audio", {
          commit: props.commit,
        });
      } else {
        alert("还没有保存过");
      }
    };

    const onDownloadCheckedAudio = async () => {
      const selectedRows = xGrid.value.getCheckboxRecords(true);
      if (selectedRows.length === 0) {
        return VXETable.modal.message({
          content: "你还没有勾选",
          status: "warning",
        });
      }
      for (let row of selectedRows) {
        const file_name = String(row.file_name).trim();
        const file_url = row.recordUrl
          ? row.recordUrl
          : row.localUrl
          ? row.localUrl
          : row.file_path;
        if (!file_name || !file_url) continue;

        const a = document.createElement("a");
        a.style.display = "none";
        a.href = file_url;
        a.setAttribute("download", file_name);
        document.body.appendChild(a);
        a.click();
        a.remove();
      }
    };

    const commitHasChanged = async () => {
      const { insertRecords, updateRecords, removeRecords } = xGrid.value.getRecordset();

      let hasRecorded = false;
      const { fullData } = xGrid.value.getTableData();
      for (let row of fullData) {
        if (row.recordFile) {
          hasRecorded = true;
          break;
        }
      }
      console.log(insertRecords.length);
      console.log(insertRecords.length);
      console.log(insertRecords.length);
      console.log(hasRecorded);
      return (
        insertRecords.length ||
        updateRecords.length ||
        removeRecords.length ||
        hasRecorded
      );
    };

    return {
      xGrid,
      xDown,
      gridOptions,
      demo,
      insertEmptyAt,
      insertAudioAt,
      insertEmptyBeforeSelected,
      insertAudioBeforeSelected,
      resetAll,
      saveForm,
      commitHasChanged,
      onSave,
      onDownloadAllAudio,
      onDownloadCheckedAudio,
      saveModalFormSubmitEvent,
      commitFocusEvent,
      commitKeyupEvent,
      onAudioPlayEvent,
    };
  },
  computed: {
    csrf() {
      return Cookies.get("XSRF-TOKEN");
    },
  },
});
</script>
