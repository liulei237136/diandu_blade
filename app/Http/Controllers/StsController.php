<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QCloud\COSSTS\Sts;
use Qcloud\Cos\Client;

class StsController extends Controller
{
    public function store()
    {
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
            'allowPrefix' => 'download/*', // 这里改成允许的路径前缀，可以根据自己网站的用户登录态判断允许上传的具体路径，例子： a.jpg 或者 a/* 或者 * (使用通配符*存在重大安全风险, 请谨慎评估使用)
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
        return $tempKeys;
    }

    public function url()
    {
        // return 1;
        $secretId = config('services.qcloud.secretId'); //替换为用户的 secretId，请登录访问管理控制台进行查看和管理，https://console.cloud.tencent.com/cam/capi
        $secretKey =config('services.qcloud.secretKey'); //替换为用户的 secretKey，请登录访问管理控制台进行查看和管理，https://console.cloud.tencent.com/cam/capi
        $region = "ap-hongkong"; //替换为用户的 region，已创建桶归属的region可以在控制台查看，https://console.cloud.tencent.com/cos5/bucket
        $cosClient = new Client(
            array(
                'region' => $region,
                // 'schema' => 'https', //协议头部，默认为http
                'schema' => 'http', //协议头部，默认为http
                'credentials' => array(
                    'secretId'  => $secretId,
                    'secretKey' => $secretKey
                )
            )
        );

        try {
            $bucket = "diandu-1307995562"; //存储桶，格式：BucketName-APPID
            $key = "dir/101.tar";  //此处的 key 为对象键，对象键是对象在存储桶中的唯一标识
            // $signedUrl = $cosClient->getObjectUrl($bucket, $key, '+10 minutes');
            $signedUrl = $cosClient->getObjectUrl($bucket, $key, '+30 seconds');
            // 请求成功
            echo $signedUrl . 'response-content-disposition=attachment';
        } catch (\Exception $e) {
            // 请求失败
            print_r($e);
        }
    }
}
