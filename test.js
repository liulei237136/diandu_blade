const { Octokit } = require("@octokit/core");
const fs = require('fs');


// const file_buffer  = fs.readFileSync('./25200.mp3');
// const contents_in_base64 = file_buffer.toString('base64');
// // Octokit.js
// // https://github.com/octokit/core.js#readme
// const octokit = new Octokit({
//     auth: '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'
//   })

//   octokit.request('PUT /repos/liulei237136/426/contents/25000.mp3', {
//     owner: 'liulei237136',
//     repo: '426',
//     path: '25000.mp3',
//     message: 'create 25000.mp3',
//     committer: {
//       name: 'liulei237136',
//       email: 'liulei237136@gmail.com'
//     },
//     content:contents_in_base64,
//   })
//   .then((res)=>{
//       console.log(res);
//   })
//   .catch((err)=>{
//       console.log(err.message);
//   });

const octokit = new Octokit({
    auth: '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'
  })

  octokit.request('GET /repos/liulei237136/426')
  .then((res)=>{
      console.log(res);
  })
  .catch((err)=>{
      console.log(err.message);
  });
