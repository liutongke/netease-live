<?php
/*
 * User: keke
 * Date: 2018/4/11
 * Time: 11:15
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

namespace netease\app;

class Http
{
    //curl请求
    public static function postCurl($url, $json, $http_header, $type = 'POST', $setopt = 10)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            // 要访问的地址
            CURLOPT_URL => $url,
            // 获取的信息以文件流的形式返回
            CURLOPT_RETURNTRANSFER => true,
            //HTTP请求头中"Accept-Encoding: "的值。支持的编码有"identity"，"deflate"和"gzip"。如果为空字符串""，请求头会发送所有支持的编码类型
            CURLOPT_ENCODING => "",
            //启用时会将服务器服务器返回的"Location: "放在header中递归的返回给服务器，使用CURLOPT_MAXREDIRS可以限定递归返回的数量
            CURLOPT_MAXREDIRS => 10,
            // 设置超时限制防止死循环
            CURLOPT_TIMEOUT => $setopt,
            //设置curl使用的HTTP协议，CURL_HTTP_VERSION_NONE（让curl自己判断），CURL_HTTP_VERSION_1_0（HTTP/1.0），CURL_HTTP_VERSION_1_1（HTTP/1.1）
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //请求类型
            CURLOPT_CUSTOMREQUEST => $type,
            // Post提交的数据包
            CURLOPT_POSTFIELDS => $json,
            // 设置HTTP头
            CURLOPT_HTTPHEADER => $http_header,
        ));

        // 执行
        $response = curl_exec($curl);
        //获取http状态码
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        // 关闭CURL会话
        curl_close($curl);

        if ($status !== 200) {
            $return_array = json_decode($response, true);
            if ($return_array) {
                $error_message = '请求错误:';
                if (isset($return_array['error']))
                    $error_message .= $return_array['error'];
                if (isset($return_array['error_description']))
                    $error_message .= ' ' . $return_array['error_description'];
            } else {
                $error_message = '请求错误!';
            }
            throw new NeteaseError($error_message, $status);
        }

        return self::ErrorCode(json_decode($response, true));
    }

    //错误码归类
    public function ErrorCode($msg)
    {
        // 错误码
        $error_code = $msg['code'];
        switch ((int)$error_code) {
            case 200:
                $message = [
                    'msg' => '发送成功',
                    'code' => $error_code,
                    'data' => $msg
                ];
                break;
            default:
                $message = [
                    'msg' => $msg['msg'],
                    'code' => $error_code
                ];
                break;
        }

        return $message;
    }
}