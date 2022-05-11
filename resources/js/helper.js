import XEUtils from "xe-utils";
import CosAuth from "./vendor/cos";
import { v4 as uuidv4 } from "uuid";

export const getCommitAudio = async (commit) => {
    console.log(commit);
    if (!commit || !commit.file_path) {
        return [];
    } else {
        const result = await axios.get(commit.file_path);
        const arr = result.data.split("\n");
        //去掉标题行
        arr.shift();
        return arr.map((line) => {
            //还有 user_name user_id created_at
            const [file_name, file_path, comment, user_name, user_id, created_at] = line.split(",");
            return {
                file_name,
                file_path,
                comment,
                user_name,
                user_id,
                created_at,
            }
        });
    }
};

export const filterStringMethod = ({ value, option, cellValue, row, column }) => {
    return XEUtils.toValueString(cellValue).toLowerCase().indexOf(option.data) > -1;
};



export const nameSortBy = ({ row, column }) => {
    const name = XEUtils.toValueString(row.file_name).trim();
    if (!name) return -1;
    //todo
    const matchMp3 = name.match("^([0-9]{1,8}).mp3$");
    if (matchMp3) {
        return parseInt(matchMp3[1]);
    } else {
        const matchNumber = name.match("^[0-9]{1,8}$");
        if (matchNumber) {
            return parseInt(matchNumber[1]);
        }
        return -1;
    }
};




// 对更多字符编码的 url encode 格式
export const camSafeUrlEncode = (str) => {
    return encodeURIComponent(str)
        .replace(/!/g, "%21")
        .replace(/'/g, "%27")
        .replace(/\(/g, "%28")
        .replace(/\)/g, "%29")
        .replace(/\*/g, "%2A");
};


// 计算签名
export const getAuthorization = (params) => {
    // return axios.post(route("sts_audio.store")).then(function (result) {
    return axios.post(route('sts.store'), params).then(function (result) {
        const credentials = result.data.tempKeys.credentials;
        const allowPrefix = result.data.allowPrefix;
        if (credentials) {
            return {
                SecurityToken: credentials.sessionToken,
                Authorization: CosAuth({
                    SecretId: credentials.tmpSecretId,
                    SecretKey: credentials.tmpSecretKey,
                    Method: params.method,
                    Pathname: allowPrefix,
                }),
                allowPrefix
            };
        } else {
            throw new Error("获取签名出错");
        }
    });
};

//type = audio, download, commit .etc
export const uploadToCos = function (type, file) {
    const Bucket = "diandu-1307995562";
    const Region = "ap-hongkong";
    const protocol = location.protocol === "https:" ? "https:" : "http:";
    const prefix = protocol + "//" + Bucket + ".cos." + Region + ".myqcloud.com/"; // prefix 用于拼接请求 url 的前缀，域名使用存储桶的默认域名
    let url;

    return getAuthorization({
        method: "PUT",
        type,
        filename:file.name,
    })
        .then((info) => {
            // alert('after sts');
            const auth = info.Authorization;
            const SecurityToken = info.SecurityToken;
            url = prefix + camSafeUrlEncode(info.allowPrefix.substr(1)).replace(/%2F/g, "/");
            const headers = { Authorization: auth };
            if (SecurityToken) {
                headers["x-cos-security-token"] = SecurityToken;
            }
            // alert('before put to cos');
            return axios.put(url, file, {
                headers: headers,
            });
        })
        .then(function (response) {
            // alert('success put to cos');
            return {
                ETag: response.headers["etag"],
                url: url,
            };
        });
};

//type = comimit
//content String
export const uploadContentToCos = function (type, content) {
    const Bucket = "diandu-1307995562";
    const Region = "ap-hongkong";
    const protocol = location.protocol === "https:" ? "https:" : "http:";
    const prefix = protocol + "//" + Bucket + ".cos." + Region + ".myqcloud.com/"; // prefix 用于拼接请求 url 的前缀，域名使用存储桶的默认域名
    let url;

    return getAuthorization({
        method: "PUT",
        type,
        filename:file.name,
    })
        .then((info) => {
            console.log(info);
            // alert('after sts');
            const auth = info.Authorization;
            const SecurityToken = info.SecurityToken;
            url = prefix + camSafeUrlEncode(info.allowPrefix.substr(1)).replace(/%2F/g, "/");
            const headers = { Authorization: auth };
            if (SecurityToken) {
                headers["x-cos-security-token"] = SecurityToken;
            }
            console.log('url ',  url);
            console.log('file', file);
            // alert('before put to cos');
            return axios.put(url, file, {
                headers: headers,
            });
        })
        .then(function (response) {
            // alert('success put to cos');
            console.log(response);
            return {
                ETag: response.headers["etag"],
                url: url,
            };
        });
};

