<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">初始化仓库</div>

          <div class="card-body">
            <!-- 标题 -->
            <h2
              v-if="!processing"
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
                <vxe-button
                  icon="fa fa-upload"
                  status="perfect"
                  size="medium"
                  @click="$refs.input.click()"
                  >上传MP3</vxe-button
                >
                <input
                  type="file"
                  ref="input"
                  accept=".mp3"
                  tw-hidden
                  multiple
                  @change="onChange"
                />
                <!-- <div class="tw-hidden md:tw-block">|</div>
          <vxe-button icon="fa fa-copy" status="perfect" @click="copy"
            >复制其他点读包音频</vxe-button
          > -->
                <div class="tw-hidden md:tw-block">|</div>
                <vxe-button
                  icon="fa fa-edit"
                  status="perfect"
                  @click="
                    $inertia.get(
                      route('package.show', { package: p.id, tab: 'audio' }),
                      {},
                      { replace: true }
                    )
                  "
                  >直接编辑</vxe-button
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log("Component mounted.");
  },
  props: ["repository","user"],
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
        const data = new FormData();
        data.append("upload_file", file);
        try {
          const result = await axios.post(route("audio.store"), data, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          });
          if (result.data.success) {
            content += file.name;
            content += "," + result.data.file_path;
            content += "," + ""; //comment empty
            content += "," + this.user.name;
            content += "," + this.user.id;
            content += "," + Date.now();
            content += "\n";
          }
        } catch (e) {
          console.log(e);
        }

        //todo error handle
        this.percent = Math.ceil((count / files.length) * 100);
      }

      window.axios.post(route("commits.store", { package: this.package.id }), {
        title: "初次保存",
        content: content,
      });
    },
  },
};
</script>
