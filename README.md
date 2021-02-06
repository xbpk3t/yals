# laravel-starter



1. 接口
    1. dingo😀
    2. jwt-auth
        1. `多表多用户系统隔离`
        2. `jwt-auth`黑名单
    3. fractal😀
    4. RSA接口加密(前台用户系统借鉴gadmin，使用RSA加密)
    5. 封装好的Exception异常类
2. 后台
    1. CORS
    2. 后台用户系统使用casbin实现RBAC
    3. 后台log
3. 常用功能
    1. 文件上传(七牛云、上传文件表)
    2. 短信发送
    3. redis常用操作`RedisService`、redis锁`RedisLock`
    4. 敏感词功能
    5. 常用辅助函数库
4. 其他
    1. laravel分模块最佳实践
    2. MRSC模型
    3. swagger
    4. 支持切换dev、test、prod环境配置
    5. 支持项目初始化
        1. 数据库迁移工具(本身jwt需要的user表，也需要迁移工具)
        2. 更新goutils等引入拓展包的版本





---

1. 工具库
    1. helpers文件夹😀
        1. 时间time😀
        2. 用户user😀
        3. url
        4. 字符串
        5. 网络
        6. 数学
        7. 文件file😀
        8. 数组array😀
        9. 业务yw😀

---

把laravel-admin的后台功能都抽出来接口

