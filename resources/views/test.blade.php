<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://unpkg.com/vue@3"></script>
</head>

<body>

    @php
        $urls = [];
        for ($i = 1; $i <= 52; $i++) {
            $urls[] = "https://cdn.jsdelivr.net/gh/liulei237136/511/{$i}.mp3";
        }
    @endphp
    <div id="app">
        @foreach ($urls as $url)
            <ul>
                <li>
                    <audio id="{{$i}}" src="{{$url}}" controls preload="none" @play="onPlay"></audio>
                </li>
            </ul>
        @endforeach
    </div>
    <script>
        Vue.createApp({
            data() {
                return {
                    message: 'Hello Vue!',
                    runningAudio: null,
                }
            },
            methods: {
                onPlay(event){
                        // console.log(event.target.id);
                        // alert(1);
                        if(this.runningAudio && this.runningAudio != event.target){
                            //1
                            this.runningAudio.pause();
                            //2

                        }
                        this.runningAudio = event.target;
                }
            },

        }).mount('#app')
    </script>
</body>

</html>
