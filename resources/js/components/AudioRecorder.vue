<template>
  <div class="flex items-center">
    <vxe-button size="mini" :content="content" @click="record"></vxe-button>
    <span class="w-12 inline-flex justify-end align-middle mr-1">
      <span class="mr-1">{{ duration }}</span>
      秒
    </span>
    <vxe-button
      size="mini"
      status="warning"
      content="停止"
      @click="recStop"
      :disabled="status === '空闲'"
    ></vxe-button>
  </div>
</template>

<script>
import { defineComponent, nextTick } from "vue";

import Recorder from "recorder-core";
import "recorder-core/src/engine/mp3";
import "recorder-core/src/engine/mp3-engine";

export default defineComponent({
  props: {
    row: Object,
    demo: Object,
  },
  emits: ["url"],
  data() {
    return {
      rec: null,
      status: "空闲", //空闲，录音，暂停，
      content: "录音", //录音，暂停，继续
      duration: 0,
      blob: null,
      recordUrl: "",
    };
  },
  components: {},
  methods: {
    record() {
      const { audio } = this.demo.playingAudio;
      console.log(audio);
      if (audio) {
        audio.pause();
      }
      if (this.status === "空闲") {
        this.recOpen(this.recStart);
      } else if (this.status === "录音") {
        this.recPause();
      } else if (this.status === "暂停") {
        this.recResume();
      }
    },
    recOpen(success) {
      let that = this;
      this.rec = Recorder({
        type: "mp3",
        sampleRate: 16000,
        bitRate: 16,
        onProcess: function (
          buffers,
          powerLevel,
          bufferDuration,
          bufferSampleRate,
          newBufferIdx,
          asyncEnd
        ) {
          that.duration = parseInt(bufferDuration / 1000);
        },
      });

      this.rec.open(
        function () {
          success && success();
        },
        function (msg, isUserNotAllow) {
        //   alert((isUserNotAllow ? "UserNotAllow，" : "") + "无法录音:" + msg);
          alert((isUserNotAllow ? "用户未授权，" : "") +  msg);
        }
      );
    },

    recStop() {
      //   const that = this;
      this.rec.stop(
        (blob, duration) => {
          console.log(
            blob,
            (window.URL || webkitURL).createObjectURL(blob),
            "时长:" + duration + "ms"
          );
          this.rec.close();
          this.rec = null;
          this.row.recordFile = blob;
          this.row.recordUrl = (window.URL || webkitURL).createObjectURL(blob);
          this.status = "空闲";
          this.content = "录音";
          //   nextTick(() => {
          //     const { audio } = demo.playingAudio;
          //     if (audio) {
          //       audio.pause();
          //       // audio.fastSeek(0);
          //     }
          //     demo.playingAudio = { audio: this.$refs.player };
          //   });
        },
        function (msg) {
          console.log("录音失败:" + msg);
          this.rec.close();
          this.rec = null;
          this.status = "空闲";
          this.content = "录音";
        }
      );
    },

    recStart() {
      this.rec.start();
      this.status = "录音";
      this.content = "暂停";
    },

    recPause() {
      this.rec.pause();
      this.status = "暂停";
      this.content = "继续";
    },

    recResume() {
      this.rec.resume();
      this.status = "录音";
      this.content = "暂停";
    },
  },
});
</script>
