<template>
  <div class="row justify-content-center">
    <p
      v-if="processing"
      class="tw-mx-auto tw-font-semibold tw-text-xl tw-text-gray-800 tw-leading-tight"
    >
      正在上传，请等待
    </p>
    <!-- 进度条 -->
    <div class="tw-max-w-7xl tw-mx-auto sm:tw-px-6 lg:tw-px-8">
      <div v-show="processing" class="tw-flex tw-justify-between">
        <progress :value="percent" class="tw-w-11/12" max="100">{{ percent }}%</progress>
        <span class="tw-shrink-0 tw-w-20"> {{ percent }}%</span>
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
          <i class="fa fa-upload"></i>&nbsp;<span>{{
            filePath ? "重新上传" : "请上传用于下载的文件"
          }}</span>
        </button>
        <span v-if="message">{{ message }}</span>
        <input type="file" ref="input" class="tw-hidden" v-on:change="onChange" />
      </div>
    </div>
    <!-- 最后显示的输入 -->
    <div v-show="file_path" class="tw-mt-4 tw-py-2 tw-flex">
      <span>已上传文件:</span><span>{{ file_name }}</span>
    </div>
    <input class="tw-hidden" type="text" name="file_path" v-model="filePath" />
    <input class="tw-hidden" type="text" name="file_name" v-model="fileName" />
  </div>
</template>

<script>
import { camSafeUrlEncode, getAuthorization } from "../helper";

// 请求用到的参数
const Bucket = "diandu-1307995562";
const Region = "ap-hongkong";
const protocol = location.protocol === "https:" ? "https:" : "http:";
const prefix = protocol + "//" + Bucket + ".cos." + Region + ".myqcloud.com/"; // prefix 用于拼接请求 url 的前缀，域名使用存储桶的默认域名

export default {
  props: {
    user_id: String,
    repository_id: String,
  },
  data() {
    return {
      processing: false,
      percent: 0,
      filePath: "",
      fileName: "",
      message: "",
      url:"",
    };
  },
  methods: {
    onChange(e) {
      const files = e.target.files;
      if (!files.length) return;

      this.processing = true;
      this.uploadAudio(files[0])
        .then((result) => {
        //   this.filePath =  this.url;
          this.fileName = files[0].name;
          this.message = `上传成功: ${files[0].name}`;
        })
        .catch((e) => {
          this.message = e.message;
          alert(e.message);
        })
        .finally(() => {
          this.processing = false;
        });
    },

    uploadAudio(file) {
      return getAuthorization({
        method: "PUT",
        type: "download",
        filename: file.name,
      }).then((info)=> {
        alert("after download info");
        const auth = info.Authorization;
        const SecurityToken = info.SecurityToken;
        this.filePath = info.allowPrefix;
        this.url =
          prefix + camSafeUrlEncode(info.allowPrefix.substr(1)).replace(/%2F/g, "/");
        const headers = { Authorization: auth };
        if (SecurityToken) {
          headers["x-cos-security-token"] = SecurityToken;
        }
        return axios.put(this.url, file, {
          headers: headers,
          onUploadProgress: (e) => {
            this.percent = Math.round((e.loaded / e.total) * 10000) / 100;
          },
        });
      });
    },
  },
};
</script>
