<?php
/*
 * User: keke
 * Date: 2018/4/11
 * Time: 9:58
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
require_once __DIR__ . '/vendor/autoload.php';
use netease\app\SayHello;
use netease\app\Netease;

$Netease = new Netease('***', '***');
//创建频道
$res = $Netease->liveChannelAdd('***', '0');
//修改频道
$res = $Netease->liveChannelUpdate('***', '***', '0');
//删除频道
$res = $Netease->liveChannelDel('***');
//获取频道状态
$res = $Netease->liveChannelGet('***');
//获取频道列表
$res = $Netease->channel_list();
//重新获取推流地址
$res = $Netease->channel_reset('***');
//设置频道为录制状态
$res = $Netease->channel_setRecord([
    'cid' => '***',
    'needRecord' => 1,
    'format' => 0,
    'duration' => 5
]);
//禁用频道
$res = $Netease->channel_pause('***');
//恢复频道
$res = $Netease->channel_resume('***');
//批量禁用频道
$res = $Netease->channel_pauselist([
    '***',
    '***'
]);
//批量恢复频道
$res = $Netease->channel_resumelist([
    '***',
    '***'
]);
//获取录制视频文件列表
$res = $Netease->channel_videolist('***');
echo "<pre />";
var_dump($res);
echo "<pre />";
//echo SayHello::world();