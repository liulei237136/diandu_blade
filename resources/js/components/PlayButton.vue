<template>
  <div class="flex items-center">
    <button
      @click="clickPlay"
      v-if="status === 'paused' || status === 'not_init' || status === 'aborted'"
      ref="play"
      type="button"
      class=" tw-flex tw-items-center"
    >
    <!-- tw-rounded-full tw-p-2 tw-bg-gray-300 -->
      <!-- <svg class="tw-w-4 tw-h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
        <path
          d="M361 215C375.3 223.8 384 239.3 384 256C384 272.7 375.3 288.2 361 296.1L73.03 472.1C58.21 482 39.66 482.4 24.52 473.9C9.377 465.4 0 449.4 0 432V80C0 62.64 9.377 46.63 24.52 38.13C39.66 29.64 58.21 29.99 73.03 39.04L361 215z"
        />
      </svg> -->
      <svg class="tw-w-7 tw-h-7"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M188.3 147.1C195.8 142.8 205.1 142.1 212.5 147.5L356.5 235.5C363.6 239.9 368 247.6 368 256C368 264.4 363.6 272.1 356.5 276.5L212.5 364.5C205.1 369 195.8 369.2 188.3 364.9C180.7 360.7 176 352.7 176 344V167.1C176 159.3 180.7 151.3 188.3 147.1V147.1zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/></svg>
      <!-- <span>{{}}</span>
      :
      <span>{{}}</span> -->
    </button>
    <!-- <button
      @click="clickPause"
      v-if="status === 'playing'"
      ref="pause"
      type="button"
      class="tw-rounded-full tw-p-2 tw-bg-gray-300"
    >
      <svg class="tw-w-4 tw-h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
        <path
          d="M272 63.1l-32 0c-26.51 0-48 21.49-48 47.1v288c0 26.51 21.49 48 48 48L272 448c26.51 0 48-21.49 48-48v-288C320 85.49 298.5 63.1 272 63.1zM80 63.1l-32 0c-26.51 0-48 21.49-48 48v288C0 426.5 21.49 448 48 448l32 0c26.51 0 48-21.49 48-48v-288C128 85.49 106.5 63.1 80 63.1z"
        />
      </svg>
    </button> -->
    <button
      @click="clickStop"
      v-if="status === 'playing'"
      ref="stop"
      type="button"
      class=" tw-flex tw-items-center"    >
      <!-- <svg class="tw-w-4 tw-h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
        <path
          d="M384 128v255.1c0 35.35-28.65 64-64 64H64c-35.35 0-64-28.65-64-64V128c0-35.35 28.65-64 64-64H320C355.3 64 384 92.65 384 128z"
        />
      </svg> -->
      <svg  class="tw-w-7 tw-h-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M328 160h-144C170.8 160 160 170.8 160 184v144C160 341.2 170.8 352 184 352h144c13.2 0 24-10.8 24-24v-144C352 170.8 341.2 160 328 160zM256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464z"/></svg>
    </button>
    <audio ref="audio" :src="src" @play="onPlay" @pause="onPause" @abort="onAbort"></audio>
  </div>
</template>

<script>
import { nextTick } from "vue";
import { onAudioPlayEvent } from "../helper";

export default {
  props: {
    row: Object,
  },
  data() {
    return {
      status: "not_init", //playing pasued
      //   audio: null,
      //   init: false,
      //   src: this.row.file_path,
      src: null,
    };
  },
  methods: {
    async clickPlay() {
      // 1.如果有播放中的audio，且不是自己，先暂停
      if (window.playingAudio && window.playingAudio.audio != this.$refs.audio) {
        // window.playingAudio.audio.fastSeek(0);
        window.playingAudio.audio.load();
        // window.playingAudio.audio.pause();
      }

      if (!this.src) {
        this.src = this.row.file_path;
        await this.$refs.audio.load();
      }
      await this.$refs.audio.play();
      window.playingAudio = { audio: this.$refs.audio };
    },

    // onAudioPlayEvent(e) {
    //   this.status = "playing";
    // },

    // clickPause() {
    //     this.$refs.audio.pause();
    // },
    // onAudioStopEvent(e) {
    //   this.status = "paused";
    // },

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

    // onAudioStopEvent(e) {
    //   this.status = "stopped";
    // },
  },
};
</script>
