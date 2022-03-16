@extends('layouts.app')

@section('title', 'init ' . $repository->name)
@section('description', $repository->excerpt)

{{-- file_name,file_path,comment,user_name,user_id,created_at
25074.mp3,http://localhost:8000/storage/audio/1/waTFueR77JE86w8jiBNYSO3Qu3TUvsUuMBB1qHRj.mp3,,parent,1,1645518455765 --}}
@section('content')
    <div class="tw-bg-white tw-py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">初始化仓库</div>

                        <div class="card-body">
                            <!-- 标题 -->
                            <h2 v-if="!processing"
                                class="tw-py-4 tw-font-semibold tw-text-xl tw-text-gray-800 tw-leading-tight">
                                选择下面的方式来初始化仓库
                            </h2>
                            <h2 v-else
                                class="tw-py-4 tw-mx-auto tw-font-semibold tw-text-xl tw-text-gray-800 tw-leading-tight">
                                正在上传音频，请等待
                            </h2>
                            <!-- 进度条 -->
                            <div class="tw-py-12 tw-max-w-7xl tw-mx-auto sm:tw-px-6 lg:tw-px-8">
                                <div v-show="processing" class="tw-flex">
                                    <progress :value="percent" class="tw-w-full" max="100">
                                        @{{ percent }}%
                                    </progress>
                                    &nbsp;@{{ percent }}%
                                </div>
                                <div v-show="!processing"
                                    class="md:tw-flex-row md:tw-space-x-4 md:tw-items-center md:tw-space-y-0 tw-w-full tw-flex tw-flex-col tw-text-left tw-space-y-4">
                                    <button type="button" class="hover:tw-text-blue-500" v-on:click="$refs.input.click()"><i
                                            class="fa fa-upload"></i>上传MP3</button>
                                    <input type="file" ref="input" accept=".mp3" class="tw-hidden" multiple
                                        v-on:change="onChange" />
                                    <div class="tw-hidden md:tw-block">|</div>
                                    <a class="tw-no-underline tw-text-gray-900"
                                        href="{{ route('repository_audio.edit', $repository->id) }}"><i
                                            class="fa fa-edit"></i>
                                        直接编辑</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop



@section('scripts')
    <script>
        const app = {
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
                            const result = await axios.post("{{ route('repositories.upload_audio') }}", data, {
                                headers: {
                                    "Content-Type": "multipart/form-data",
                                },
                            });
                            if (result.data.success) {
                                content += file.name;
                                content += "," + result.data.file_path;
                                content += "," + ""; //comment empty
                                content += "," + "{{ auth()->user()->name }}";
                                content += "," + "{{ auth()->user()->id }}";
                                content += "," + Date.now();
                                content += "\n";
                            }
                        } catch (e) {
                            console.log(e);
                        }

                        //todo error handle
                        this.percent = Math.ceil((count / files.length) * 100);
                    }

                    try {
                        const result = await window.axios
                            .post("{{ route('commits.store', $repository->id) }}", {
                                title: "初次保存",
                                content: content,
                            });
                        // console.log(result);
                        if(result.data.success){
                            window.location.href = route('repository_audio.edit', {repository: "{{$repository->id}}", commit: result.data.commit_id});
                        }else{
                            console.log(result.data.message);
                            alert(result.data.message);
                        }
                    }catch(e){
                        console.log(e);
                        alert(e.message);
                    }


                },
            },
        };


        window.createApp(app).mount('#app');
    </script>

@endsection
