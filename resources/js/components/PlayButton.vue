<template>
  <div class="flex items-center">
    <button
      @click="clickPlay"
      v-if="status === 'paused' || status === 'not_init' || status === 'aborted'"
      ref="play"
      type="button"
      class=" tw-flex tw-items-center"
    >
      <svg class="tw-w-7 tw-h-7"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">><path d="M188.3 147.1C195.8 142.8 205.1 142.1 212.5 147.5L356.5 235.5C363.6 239.9 368 247.6 368 256C368 264.4 363.6 272.1 356.5 276.5L212.5 364.5C205.1 369 195.8 369.2 188.3 364.9C180.7 360.7 176 352.7 176 344V167.1C176 159.3 180.7 151.3 188.3 147.1V147.1zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/></svg>
    </button>
    <button
      @click="clickStop"
      v-if="status === 'playing'"
      ref="stop"
      type="button"
      class=" tw-flex tw-items-center"    >
      <svg  class="tw-w-7 tw-h-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M328 160h-144C170.8 160 160 170.8 160 184v144C160 341.2 170.8 352 184 352h144c13.2 0 24-10.8 24-24v-144C352 170.8 341.2 160 328 160zM256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464z"/></svg>
    </button>
    <audio ref="audio" :src="src" @play="onPlay" @pause="onPause" @abort="onAbort"></audio>
  </div>
</template>

<script>

export default {
  props: {
    row: Object,
  },
  data() {
    return {
      status: "not_init", //playing pasued
      src: null,
    };
  },
  methods: {
    async clickPlay() {
      // 1.如果有播放中的audio，且不是自己，先暂停
      if (window.playingAudio && window.playingAudio.audio != this.$refs.audio) {
        window.playingAudio.audio.load();
      }

      if (!this.src) {
        this.src = this.row.file_path;
        await this.$refs.audio.load();
      }
      await this.$refs.audio.play();
      window.playingAudio = { audio: this.$refs.audio };
    },


    clickStop() {
      //   this.$refs.audio.fastSeek(0);
      //   this.$refs.audio.pause();
      this.$refs.audio.load();
    },
    onPlay() {
      this.status = "playing";
    },
    onPause() {
      this.status = "paused";
    },
    onAbort(){
        this.status = "aborted";
    }
  },
};
</script>
