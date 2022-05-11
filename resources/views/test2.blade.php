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
    <div id="app">
        <input type="file" @change="onChange">
    </div>
    <script type="module">
        import {
            Octokit
        } from "https://cdn.skypack.dev/@octokit/core";
        const getOctokit = () => {
            return new Octokit({
                auth: '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'
            });
        }

        // function getBase64(file) {
        //     return new Promise((resolve, reject) => {
        //         const reader = new FileReader();
        //         reader.readAsText(file, 'base64');
        //         reader.onload = () => resolve(reader.result);
        //         reader.onerror = error => reject(error);
        //     });
        // }

        function getBase64(audioFile) {
            return new Promise((resolve, reject) => {
                var reader = new FileReader();
                reader.readAsDataURL(audioFile);
                reader.onload = function(event) {
                    var data = event.target.result.split(','),
                        decodedImageData = btoa(data[
                            1]); // the actual conversion of data from binary to base64 format
                    resolve(decodedImageData);
                };
                reader.onerror = error => reject(error);
            });
        }


        const addFile = (repo, path, base64_content) => {
            return getOctokit().request('PUT /repos/{owner}/{repo}/contents/{path}', {
                // 'content-type': 'application/vnd.github.VERSION.object'
                // accept: 'application/vnd.github.v3+json',
                owner: 'liuleisqc',
                repo: repo,
                path: path,
                message: 'my commit message',
                // content: base64_content,
                content: base64_content,
            })
        }

        Vue.createApp({
            methods: {
                onChange(event) {
                    const file = event.target.files[0];
                    if (!file) return;
                    getBase64(file)
                        .then(base64_content => {
                            return addFile('repo1', file.name, base64_content)
                        })
                        .then(() => {
                            console.log('succes');
                        })
                        .catch((err) => {
                            console.log(err.message);
                        })
                }
            },

        }).mount('#app')
    </script>
</body>

</html>
