# laravel-starter

把日常开发中的常用功能抽出来做一个starter，避免每次开新项目时耗费的大量重复工作，该repo会长期维护。在使用中如有bug或体验问题，请提issue。

## 基本功能

1. api模块
    1. dingo😀
    2. jwt-auth
        1. `多表多用户系统隔离`😀
        2. `jwt-auth`黑名单
    3. fractal😀
    4. RSA接口加密(前台用户系统借鉴gadmin，使用RSA加密)
    5. 封装好的Exception异常类
    6. 记录每条请求的参数和响应-后置中间件
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
    2. MRSC模型(已留出文件夹，具体业务相关不写)😀
    3. swagger(php的swagger不好用，不写)😀
    4. 支持切换dev、test、prod环境配置😀
    5. 支持项目初始化
        1. 数据库迁移工具(本身jwt需要的user表，也需要迁移工具)
        2. 更新goutils等引入拓展包的版本
    6. laravel错误日志的最佳实践
5. 代码质量
    1. php-cs-fixer`php-cs-fixer fix $PWD --config=cs.php`
    2. 静态检测工具:基于phpstan实现的larastan`./vendor/bin/phpstan analyse`
5. 常用功能
    1. 第三方登录(微信登录、qq登录)
    2. 第三方支付(微信支付、支付宝)
    3. url转二维码
    4. 图片验证码



## 安装

### 手动安装

1. *clone项目*。`gcl git@github.com:x1a0xv4n/laravel-starter.git`
2. *切换分支*。切换分支到对应laravel版本，master分支默认为laravel最新版本`git checkout -b origin/target-version-branch`
3. *配置文件*。开发环境下，请复制.env.prod为.env.dev，并填写dingo的基本配置，如有问题，请发issue。
4. sql文件。执行根目录下的laravel_starter.sql。



### docker-compose安装

暂时没空，过两天再写


## changelog











