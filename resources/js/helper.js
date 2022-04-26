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
export const getAuthorization = (options) => {
    // return axios.post(route("sts_audio.store")).then(function (result) {
    return axios.get(options.route).then(function (result) {
        const credentials = result.data.credentials;
        if (credentials) {
            return {
                SecurityToken: credentials.sessionToken,
                Authorization: CosAuth({
                    SecretId: credentials.tmpSecretId,
                    SecretKey: credentials.tmpSecretKey,
                    Method: options.Method,
                    Pathname: options.Pathname,
                }),
            };
        } else {
            throw new Error("获取签名出错");
        }
    });
};

//type = audio, download, commit .etc
export const uploadToCos = function (file, user_id, type) {
    const Bucket = "diandu-1307995562";
    const Region = "ap-hongkong";
    const protocol = location.protocol === "https:" ? "https:" : "http:";
    const prefix = protocol + "//" + Bucket + ".cos." + Region + ".myqcloud.com/"; // prefix 用于拼接请求 url 的前缀，域名使用存储桶的默认域名

    const date = new Date();
    const year = date.getFullYear();
    const month = date.getMonth() + 1;
    const day = date.getDate();
    const uuid = uuidv4().substr(0, 4);

    var key = `${type}/${year}${month}/${day}/${user_id}_${Date.now()}_${uuid}_${file.name}`;
    let url = "";

    return getAuthorization({
        Method: "PUT",
        Pathname: "/" + key,
        route: route(`sts_${type}.store`),
    })
        .then((info) => {
            const auth = info.Authorization;
            const SecurityToken = info.SecurityToken;
            url = prefix + camSafeUrlEncode(key).replace(/%2F/g, "/");
            const headers = { Authorization: auth };
            if (SecurityToken) {
                headers["x-cos-security-token"] = SecurityToken;
            }
            return axios.put(url, file, {
                headers: headers,
            });
        })
        .then(function (response) {
            return {
                ETag: response.headers["etag"],
                url: url,
            };
        });
};

export const getCosSignedUrl = (file, user_id, type) => {
    const Bucket = "diandu-1307995562";
    const Region = "ap-hongkong";
    const protocol = location.protocol === "https:" ? "https:" : "http:";
    const prefix = protocol + "//" + Bucket + ".cos." + Region + ".myqcloud.com/"; // prefix 用于拼接请求 url 的前缀，域名使用存储桶的默认域名

    const date = new Date();
    const year = date.getFullYear();
    const month = date.getMonth() + 1;
    const day = date.getDate();
    const uuid = uuidv4().substr(0, 4);

    var key = `${type}/${year}${month}/${day}/${user_id}_${Date.now()}_${uuid}_${file.name}`;

    return getAuthorization({
        Method: "PUT",
        Pathname: "/" + key,
        route: route(`sts_${type}.store`),
    })
        .then((info) => {
            const auth = info.Authorization;
            const SecurityToken = info.SecurityToken;
            url = prefix + camSafeUrlEncode(key).replace(/%2F/g, "/");
            const headers = { Authorization: auth };
            if (SecurityToken) {
                headers["x-cos-security-token"] = SecurityToken;
            }
            return {
                headers,
                url,
            };
        });
}
