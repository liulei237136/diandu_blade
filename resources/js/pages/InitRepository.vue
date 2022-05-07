<template>
  <div class="tw-bg-white tw-py-4">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">初始化仓库</div>

            <div class="card-body">
              <!-- 标题 -->
              <h2
                v-if="!processing"
                class="tw-py-4 tw-font-semibold tw-text-xl tw-text-gray-800 tw-leading-tight"
              >
                选择下面的方式来初始化仓库
              </h2>
              <h2
                v-else
                class="tw-py-4 tw-mx-auto tw-font-semibold tw-text-xl tw-text-gray-800 tw-leading-tight"
              >
                正在上传音频，请等待
              </h2>
              <!-- 进度条 -->
              <div class="tw-py-12 tw-max-w-7xl tw-mx-auto sm:tw-px-6 lg:tw-px-8">
                <div v-show="processing" class="tw-flex">
                  <progress :value="percent" class="tw-w-full" max="100">
                    {{ percent }}%
                  </progress>
                  &nbsp;{{ percent }}%
                </div>
                <div
                  v-show="!processing"
                  class="md:tw-flex-row md:tw-space-x-4 md:tw-items-center md:tw-space-y-0 tw-w-full tw-flex tw-flex-col tw-text-left tw-space-y-4"
                >
                  <button
                    type="button"
                    class="hover:tw-text-blue-500"
                    v-on:click="$refs.input.click()"
                  >
                    <i class="fa fa-upload"></i>上传MP3
                  </button>
                  <input
                    type="file"
                    ref="input"
                    accept=".mp3"
                    class="tw-hidden"
                    multiple
                    v-on:change="onChange"
                  />
                  <div class="tw-hidden md:tw-block">|</div>
                  <a
                    class="tw-no-underline tw-text-gray-900"
                    :href="route('repository_audio.edit', repository.id)"
                    ><i class="fa fa-edit"></i> 直接编辑</a
                  >
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {uploadToCos} from "../helper";

export default {
  props: {
    repository: Object,
    user: Object,
  },
  data() {
    return {
      processing: false,
      percent: 0,
    };
  },
  methods: {
    async onChange(e) {
      const files = e.target.files;
      if (!files.length) return;

      let content = "file_name,file_path,comment,user_name,user_id,created_at\n";
      let count = 0;

      this.processing = true;
      for (let file of files) {
        count++;
        try {
        //   const { url } = await uploadToCos(file, this.user.id, 'audio');
        //uploadToCos(type, filename)
          const { url } = await uploadToCos('audio', file.name);

          content += file.name;
          content += "," + url;
          content += "," + ""; //comment empty
          content += "," + this.user.name;
          content += "," + this.user.id;
          content += "," + Date.now();
          content += "\n";
        } catch (error) {
            console.log(error);
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

        //todo error handle
        this.percent = Math.ceil((count / files.length) * 100);
      }

      try {
        const result = await window.axios.post(
          route("commits.store", this.repository.id),
          {
            title: "初次保存",
            content: content,
          }
        );
        if (result.data.success) {
          window.location.href = route("repository_audio.edit", {
            repository: this.repository.id,
            commit: result.data.commit_id,
          });
        } else {
          console.log(result.data.message);
        //   alert(result.data.message);
        }
      } catch (e) {
        console.log(e);
        // alert(e.message);
      }
    },
  },
};
</script>
