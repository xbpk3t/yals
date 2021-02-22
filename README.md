# laravel-starter

把日常开发中的常用功能抽出来做一个starter，避免每次开新项目时耗费时间去做大量重复工作，该repo会长期维护，欢迎大家star。在使用中如有bug或体验问题，请提issue。


## 基本功能

1. api模块
    1. dingo😀
    2. jwt-auth
        1. `多表多用户系统隔离`😀
        2. `jwt-auth`黑名单
    3. fractal😀
    4. RSA接口加密
    5. 封装好的Exception异常类
    6. 记录每条请求的参数和响应-后置中间件😀
2. admin模块
    1. CORS😀
    2. RBAC😀
    3. 后台log-后置中间件😀
3. common模块
    1. 文件上传(七牛云、并记录附件)😀
    2. 短信发送😀
    3. redis常用操作`RedisService`、redis锁`RedisLock`😀
    4. 敏感词功能😀
    5. 常用辅助函数库😀
4. 其他
    1. laravel分模块的最佳实践😀
    2. MRSC模型😀
    3. swagger(php的swagger不好用，不写)😀
    4. 支持切换dev、test、prod环境配置😀
    5. 支持项目初始化
        1. 数据库迁移工具
    6. laravel错误日志的最佳实践
5. 代码质量
    1. php-cs-fixer😀`php-cs-fixer fix $PWD --config=cs.php`
    2. 静态检测工具😀:基于phpstan实现的larastan`./vendor/bin/phpstan analyse`
6. 常用功能
    1. 第三方登录(微信登录、qq登录)
    2. 第三方支付(微信支付、支付宝)
    3. url转二维码
    4. 图片验证码



## 部署

### 手动部署

1. *clone项目*。`gcl git@github.com:x1a0xv4n/laravel-starter.git`
2. *切换分支*。切换分支到对应laravel版本，master分支默认laravel最新版本`git checkout -b origin/target-version-branch`
3. *配置文件*。开发环境下，请复制`.env.prod`为`.env.dev`，并填写基本配置如数据库、redis、dingo等，如有问题，请发issue。
4. *sql文件*。执行根目录下的`laravel_starter.sql`
5. *部署服务*。



### docker-compose部署

暂时没空，过两天再写



## 使用说明

1. 使用`php artisan module:make Demo`生成指定模块名，更多命令请查看拓展包[nWidart/laravel-modules](https://github.com/nWidart/laravel-modules)


## todo

1. docker-compose部署
2. 手动部署也可以直接使用命令初始化项目，优化使用体验
3. 链路追踪: 使用zipkin作为laravel的链路追踪方案
4. 删掉没用的代码，从框架加载角度，优化一下laravel








