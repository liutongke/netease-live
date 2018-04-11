# 网易云直播
Installation 使用 Composer 安装 在项目中的 composer.json 文件中添加依赖：
```shell
“require”: {
    “mobile/push”: “dev-master”
},
```
执行 $ composer update 进行安装。
首先引入：
```php
use netease\app\Netease;
$Netease = new Netease(AppSecret,AppSecret);
```

//创建频道
```php
$res = $Netease->liveChannelAdd(频道名称, 频道类型（0:rtmp）);
```
//修改频道
```php
$res = $Netease->liveChannelUpdate(频道名,频道ID,频道类型 ( 0 : rtmp));
```
//删除频道
```php
$res = $Netease->liveChannelDel(频道ID);
```
//获取频道状态
```php
$res = $Netease->liveChannelGet(频道ID);
```
//获取频道列表
```php
$res = $Netease->channel_list();
```
//重新获取推流地址
```php
$res = $Netease->channel_reset(频道ID);
```
//设置频道为录制状态
```php
$res = $Netease->channel_setRecord([
    'cid' => 频道ID,
    'needRecord' => 1-开启录制； 0-关闭录制,
    'format' => 1-flv； 0-mp4,
    'duration' => 录制切片时长(分钟)，5~120分钟
]);
```
//禁用频道
```php
$res = $Netease->channel_pause(频道ID);
```
//恢复频道
```php
$res = $Netease->channel_resume(频道ID);
```
//批量禁用频道
```php
$res = $Netease->channel_pauselist([
    频道ID
]);
```
//批量恢复频道
```php
$res = $Netease->channel_resumelist([
    频道ID
]);
```
//获取录制视频文件列表
```php
$res = $Netease->channel_videolist(频道ID);
```