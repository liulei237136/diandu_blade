<?php

namespace App\Http\Controllers;

use App\Http\Requests\StsRequest;
use Illuminate\Http\Request;
use QCloud\COSSTS\Sts;
use Illuminate\Support\Str;

class StsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(StsRequest $request)
    {

        //request->method
        //request->type 'audio' 'upload' etc
        //request->filename
        switch($request->type){
            case 'audio':
                // uploads/images/$folder/" . date("Ym/d", time());
                 $allowPrefix = "/uploads/audio/" . date("Ym/d", time()) . '/' . auth()->id() . '_' . (now())->getTimestamp() . '_' . Str::random(4) . '/' . $request->filename;
                 break;
             case 'download':
                 $allowPrefix = "/uploads/downloads/" . date("Ym/d", time()) . '/' . auth()->id() . '_' . (now())->getTimestamp() . '_' . Str::random(4) . '/' . $request->filename;
                break;
             case 'commit':
                 $allowPrefix = "/uploads/commits/" . date("Ym/d", time()) . '/' . auth()->id() . '_' . (now())->getTimestamp() . '_' . Str::random(4) . '/' . $request->filename;
                break;
        }
        $sts = new Sts();
        $config = array(
            'url' => 'https://sts.tencentcloudapi.com/',
            'domain' => 'sts.tencentcloudapi.com', // 域名，非必须，默认为 sts.tencentcloudapi.com
            'proxy' => '',
            'secretId' => config('services.qcloud.secretId'), // 固定密钥,若为明文密钥，请直接以'xxx'形式填入，不要填写到getenv()函数中
            'secretKey' => config('services.qcloud.secretKey'), // 固定密钥,若为明文密钥，请直接以'xxx'形式填入，不要填写到getenv()函数中
            'bucket' => config('services.qcloud.bucket'),
            'region' => config('services.qcloud.region'),
            'durationSeconds' => 1800, // 密钥有效期
            'allowPrefix' => $allowPrefix, // 这里改成允许的路径前缀，可以根据自己网站的用户登录态判断允许上传的具体路径，例子： a.jpg 或者 a/* 或者 * (使用通配符*存在重大安全风险, 请谨慎评估使用)
            // 密钥的权限列表。简单上传和分片需要以下的权限，其他权限列表请看 https://cloud.tencent.com/document/product/436/31923
            'allowActions' => array(
                // 简单上传
                'name/cos:PutObject',
                'name/cos:PostObject',
                // 分片上传
                'name/cos:InitiateMultipartUpload',
                'name/cos:ListMultipartUploads',
                'name/cos:ListParts',
                'name/cos:UploadPart',
                'name/cos:CompleteMultipartUpload'
            )
        );

        // 获取临时密钥，计算签名
        $tempKeys = $sts->getTempKeys($config);
        // return $tempKeys;
        return [
            'tempKeys' => $tempKeys,
            'allowPrefix' => $allowPrefix,
        ];
    }


}
