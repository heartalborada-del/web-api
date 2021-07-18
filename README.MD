# Heartalborada's Web api

## 这是什么东西?

这是一个Web api的源码,去这里有api演示[Heartalborada's Api](https://api.loliurl.club/)

## 此api源码内含什么api

1. [Bilibili api](https://api.loliurl.club/help/bilibili/)
2. [实时天气api](https://api.loliurl.club/help/weather/)
3. [天气卡片api](https://api.loliurl.club/help/weather-card/)[注1: 根据IP判断的api有几率不准确, 特别是3/4/5G流量 ;注2: 国外IP无天气信息]

## 怎么使用此api?

除实时天气api之外,其他api不需要设置;

### 实时天气api使用教程

1. 去[高德开发平台注册一个账号](https://lbs.amap.com/)
2. 获取Apikey
3. 将Apikey填写到"weather"目录下的"index.php"的"$key"变量中
4. 将自己的api地址填写到"weather-card"目录下的"index.php"的"$api_url"变量中
4. 即可使用
