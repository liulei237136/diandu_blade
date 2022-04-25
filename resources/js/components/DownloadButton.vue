<template>
  <button
    @click="onClick"
    class="tw-rounded tw-px-4 tw-py-2 tw-bg-indigo-500 tw-text-white hover:tw-bg-indigo-600 disabled:tw-bg-indigo-300"
    type="button"
    :disabled="processing"
  >
    {{ processing ? "正在请求下载..." : "下载文件" }}
  </button>
</template>

<script>
export default {
  props: {
    download_id: Number,
  },
  data() {
    return {
      processing: false,
      tempUrl: "",
    };
  },
  methods: {
    onClick(e) {
      this.processing = true;
      axios
        .get(route("repository-downloads.get-temp-url", { download: this.download_id }))
        .then((res) => {
          if (res.data.success) {
            this.createDownloadLink(res.data.data);
          } else {
            throw new Error(res.data.message);
          }
        })
        .catch((err) => {
          alert(err.message);
        })
        .finally(() => {
          this.processing = false;
        });
    },

    createDownloadLink(url) {
      const a = window.document.createElement("a");
      a.style.display = "none";
      a.href = url;
      document.body.appendChild(a);
      a.click();
      a.remove();
    },
  },
};
</script>
