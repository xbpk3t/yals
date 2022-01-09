# laravel-starter

把日常开发中的常用功能抽出来做一个starter，避免每次开新项目时耗费时间去做大量重复工作，该repo会长期维护，欢迎大家star。在使用中如有bug或体验问题，请提issue。


## 基本功能

### api模块

1. `dingo`+`jwt-auth`+`fractal`
2. RSA接口加密
3. 封装好的Exception异常类
4. api模块的log(记录每条请求的参数和响应)

### admin模块

1. CORS跨域
2. RBAC权限控制
3. admin模块的log

### common模块

1. 文件上传(七牛云，并记录附件)
2. 短信发送
3. 封装了redis常用操作`RedisService`和redis锁`RedisLock`
4. 敏感词功能
5. 常用辅助函数库

### 其他

1. laravel分模块的最佳实践
2. MRSC模型
3. ~~swagger(php的swagger不好用，不写)~~
4. 支持切换dev/test/prod环境配置
5. 支持项目初始化(数据库迁移工具)
6. laravel错误日志的最佳实践

#### 代码质量

1. php-cs-fixer`php-cs-fixer fix $PWD --config=cs.php`
2. 静态检测工具larastan`./vendor/bin/phpstan analyse`

#### 常用功能

1. 第三方登录(微信登录、qq登录)
2. 第三方支付(微信支付、支付宝)
3. url转二维码
4. 图片验证码




## 使用说明

### 部署

1. clone项目。`gh repo clone 91php/laravel-starter`
3. `docker-compose up --build`部署服务，具体使用查看[aschmelyun/docker-compose-laravel](https://github.com/aschmelyun/docker-compose-laravel)


### 二次开发

1. 使用`php artisan module:make Demo`生成指定模块名，具体使用查看[nWidart/laravel-modules](https://github.com/nWidart/laravel-modules)


## todo

1. 第三方登录(微信登录、qq登录)
2. 第三方支付(微信支付、支付宝)
3. 自己实现并添加类似ThinkPHP5的`场景验证`，很好用
4. 链路追踪: 使用zipkin作为laravel的链路追踪方案






