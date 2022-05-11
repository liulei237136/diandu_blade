// import { Octokit } from "@octokit/core"
// import fs from fs;
const { Octokit } = require('@octokit/core');
const fs = require('fs');
const octokit = new Octokit({
    auth: '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'
});

const getOctokit = () => {
    return new Octokit({
        auth: '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'
    });
}

export const createRepo = (name) => {
    return octokit.request('POST /user/repos', {
        accept: 'application/vnd.github.v3+json',
        name: name,
    });
}

export const addFile = (repoName, filePath, fileToUpload) => {
    return new Promise((resolve) => {
        const reader = new FileReader();
        reader.readAsDataURL(fileToUpload);

        reader.onload = function (e) {
            getOctokit.request('PUT /repos/{owner}/{repo}/contents/{path}',
            {
                accept: 'application/vnd.github.v3+json',
                owner: 'liuleisqc',
                repo: repoName,
                path: filePath,
                message: 'my commit message',
                content: this.result,
            })
        }

    })
}


const base64_content = fs.readFileSync(__dirname + '/1.mp3').toString('base64');

octokit.request('PUT /repos/{owner}/{repo}/contents/{path}',
    {
        accept: 'application/vnd.github.v3+json',
        owner: 'liuleisqc',
        repo: 'repo1',
        path: 'audio/test/1.mp3',
        message: 'my commit message',
        content: base64_content,
    })
    .then(() => {
        console.log('success ');
    })
    .catch((err) => {
        console.log(2);
        console.log(err.message);
    });
