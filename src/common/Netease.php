<?php
/*
 * User: keke
 * Date: 2017/10/3
 * Time: 15:21
 *——————————————————佛祖保佑 ——————————————————
 *                   _ooOoo_
 *                  o8888888o
 *                  88" . "88
 *                  (| -_- |)
 *                  O\  =  /O
 *               ____/`---'\____
 *             .'  \|     |//  `.
 *            /  \|||  :  |||//  \
 *           /  _||||| -:- |||||-  \
 *           |   | \\  -  /// |   |
 *           | \_|  ''\---/''  |   |
 *           \  .-\__  `-`  ___/-. /
 *         ___`. .'  /--.--\  `. . __
 *      ."" '<  `.___\_<|>_/___.'  >'"".
 *     | | :  ` - `.;`\ _ /`;.`/ - ` : | |
 *     \  \ `-.   \_ __\ /__ _/   .-` /  /
 *======`-.____`-.___\_____/___.-`____.-'======
 *                   `=---='
 *——————————————————代码永无BUG —————————————————
 */

namespace composertest\src\common\Netease;

use composertest\src\common\Curl\Curl;
use Exception;
use DateTime;

class Netease
{
    private $url;                   //请求的网易云直播的网址
    private $AppKey;                //开发者平台分配的AppKey
    private $AppSecret;             //开发者平台分配的AppSecret,可刷新
    private $Nonce;                 //随机数（最大长度128个字符）
    private $CurTime;               //当前UTC时间戳，从1970年1月1日0点0 分0 秒开始到现在的秒数(String)
    private $CheckSum;              //SHA1(AppSecret + Nonce + CurTime),三个参数拼接的字符串，进行SHA1哈希计算，转化成16进制字符(String，小写)
    const   HEX_DIGITS = "0123456789abcdef";

    public function __construct($AppKey, $AppSecret)
    {
        $this->AppKey = $AppKey;
        $this->AppSecret = $AppSecret;
    }

    //生成验证码
    public function CheckSumBuilder()
    {
        //此部分生成随机字符串
        $hex_digits = self::HEX_DIGITS;
        $this->Nonce;
        for ($i = 0; $i < 128; $i++) {
            //随机字符串最大128个字符，也可以小于该数
            $this->Nonce .= $hex_digits[rand(0, 15)];
        }
        //当前时间戳，以秒为单位
        $this->CurTime = (string)(time());
        $join_string = $this->AppSecret . $this->Nonce . $this->CurTime;
        $this->CheckSum = sha1($join_string);
    }

    //curl发送数据
    public function postDataCurl($data = array())
    {
        //发送请求前需先生成checkSum
        $this->checkSumBuilder();
        if (!empty($data)) {
            $json = json_encode($data);
        } else {
            $json = "";
        }
        $http_header = array(
            'AppKey:' . $this->AppKey,
            'Nonce:' . $this->Nonce,
            'CurTime:' . $this->CurTime,
            'CheckSum:' . $this->CheckSum,
            'Content-Type: application/json;charset=utf-8;',
            'Content-Length: ' . strlen($json)
        );
        //请求数据
        Curl::set('CURLOPT_HTTPHEADER', $http_header)
            ->post($json)
            ->url($this->url);
        //对结果进行判断
        if (Curl::error()) {
            return Curl::message();
        } else {
            // 返回的内容
            return json_decode(Curl::data(), true);
        }


    }

    //创建流
    public function liveStreamsAdd($livename, $type)
    {
        return $this->postDataCurl(array('name' => $livename, 'type' => $type));
    }
}