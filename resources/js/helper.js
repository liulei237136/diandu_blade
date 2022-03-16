import XEUtils from "xe-utils";

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
