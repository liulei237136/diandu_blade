<template>
  <div class="row justify-content-center">
    <p
      v-if="processing"
      class="tw-mx-auto tw-font-semibold tw-text-xl tw-text-gray-800 tw-leading-tight"
    >
      正在上传音频，请等待
    </p>
    <!-- <p v-else-if="!processing && file_path">上传完成</p> -->
    <!-- 进度条 -->
    <div class="tw-max-w-7xl tw-mx-auto sm:tw-px-6 lg:tw-px-8">
      <div v-show="processing" class="tw-flex">
        <progress :value="percent" class="tw-w-full" max="100">{{ percent }}%</progress>
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
          <i class="fa fa-upload"></i>&nbsp;<span>{{
            this.file_path ? "重新上传" : "上传用于下载的文件"
          }}</span>
        </button>
        <span v-if="message">{{ message }}</span>
        <input type="file" ref="input" class="tw-hidden" v-on:change="onChange" />
      </div>
    </div>
    <!-- 最后显示的输入 -->
    <div v-show="file_path" class="tw-mt-4 tw-py-2">
      <span>已上传文件:</span>
      <input class="tw-w-full" type="text" required name="file_path" :value="file_path" />
    </div>
  </div>
</template>

<script>
import CosAuth from "./cos";

// 请求用到的参数
var Bucket = "diandu-1307995562";
var Region = "ap-hongkong";
var protocol = location.protocol === "https:" ? "https:" : "http:";
var prefix = protocol + "//" + Bucket + ".cos." + Region + ".myqcloud.com/"; // prefix 用于拼接请求 url 的前缀，域名使用存储桶的默认域名

export default {
  //   props: {
  //     repository: Object,
  //     user: Object,
  //   },
  data() {
    return {
      processing: false,
      percent: 0,
      file_path: null,
      message: "",
    };
  },
  methods: {
    // async onChange(e) {
    //   const that = this;
    //   const files = e.target.files;
    //   if (!files.length) return;

    //   this.processing = true;
    //   const data = new FormData();
    //   data.append("upload_file", files[0]);
    //   try {
    //     const result = await axios.post(route("repositories.upload_download"), data, {
    //       headers: {
    //         "Content-Type": "multipart/form-data",
    //       },
    //       onUploadProgress: function (progressEvent) {
    //         //   alert(progressEvent);
    //         const { loaded, total } = progressEvent;
    //         that.percent = Math.floor((loaded * 100) / total) - 1;
    //       },
    //     });
    //     console.log(result.data);
    //     this.processing = false;
    //     if (result.data.success) {
    //       this.file_path = result.data.file_path;
    //     } else {
    //       console.log(result.data.msg);
    //     }
    //   } catch (e) {
    //     console.log(e);
    //     this.processing = false;
    //   }
    // },
    onChange(e) {
      const files = e.target.files;
      if (!files.length) return;

      this.processing = true;
      this.uploadFile(files[0])
        .then(({ ETag, url }) => {
          // console.log(res);
          this.file_path = url;
          this.message = "上传成功";
        })
        .catch((e) => {
          this.message = e.message;
        })
        .finally(() => {
          this.processing = false;
        });
    },

    // 对更多字符编码的 url encode 格式
    camSafeUrlEncode(str) {
      return encodeURIComponent(str)
        .replace(/!/g, "%21")
        .replace(/'/g, "%27")
        .replace(/\(/g, "%28")
        .replace(/\)/g, "%29")
        .replace(/\*/g, "%2A");
    },
  },

  // 计算签名
  getAuthorization(options) {
    return axios.get(route("sts.store")).then((result) => {
      const credentials = result.data.credentials;
      if (credentials) {
        return {
          SecurityToken: credentials.sessionToken,
          Authorization: CosAuth({
            SecretId: credentials.tmpSecretId,
            SecretKey: credentials.tmpSecretKey,
            Method: options.Method,
            Pathname: options.Pathname,
          }),
        };
      } else {
        throw new Error("获取签名出错");
      }
    });
  },

  uploadFile(file) {
    var Key = "download/" + file.name; // 这里指定上传目录和文件result名

    this.getAuthorization({ Method: "PUT", Pathname: "/" + Key })
      .then((info) => {
        const auth = info.Authorization;
        const SecurityToken = info.SecurityToken;
        const url = prefix + camSafeUrlEncode(Key).replace(/%2F/g, "/");
        const headers = { Authorization: auth };
        if (SecurityToken) {
          headers["x-cos-security-token"] = SecurityToken;
        }
        return axios.put(
          url,
          {},
          {
            headers: headers,
            onUploadProgress: (event) => {
              this.percent = Math.round((e.loaded / e.total) * 10000) / 100;
            },
          }
        );
      })
      .then((response) => {
        if (/^2\d\d$/.test(response.status)) {
          return {
            ETag: response.headers["etag"],
            url,
          };
        } else {
          // console.log()
          throw new Error("文件 " + Key + " 上传失败，状态码：" + response.status);
        }
      });
  },
};
</script>
