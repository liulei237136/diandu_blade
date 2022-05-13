const { Octokit } = require('@octokit/core');

const getOctokit = () => {
    return new Octokit({
        auth: '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'
    });
}

export const getBase64 = (file) => {
    return new Promise((resolve, reject) => {
        var reader = new FileReader();
        reader.readAsDataURL(audioFile);
        reader.onload = function (event) {
            const base64Content = event.target.result.split(',')[1];
            resolve(base64Content);
        };
        reader.onerror = error => reject(error);
    });
}

export const createRepo = (name) => {
    return octokit.request('POST /user/repos', {
        accept: 'application/vnd.github.v3+json',
        name: name,
    });
}

export const addFile = (repo, file) => {
    return getBase64(file)
        .then((base64Content) => {
            return getOctokit().request('PUT /repos/{owner}/{repo}/contents/{path}', {
                accept: 'application/vnd.github.v3+json',
                owner: 'liuleisqc',
                repo: repo,
                path: file.name,
                content: base64Content,
            });
        });
}
