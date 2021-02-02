# laravel-starter

1. 工具库
    1. goutils😀
        1. 时间
        2. 用户
        3. url
        4. 字符串
        5. 网络
        6. 数学
        7. 文件
        8. 数组
    2. 跟gf结合较深的
        1. response😀
        2. request😀
        3. page
        4. 通用查询参数
            1. query/startTime/endTime
            2. 通用分页参数
        5. 封装好的Exception异常类`SuperExceptionHandler`
2. 常用功能
    1. 文件上传(七牛云、上传文件表)。😀
    2. 短信发送
    3. 中间件
        1. cors😀
        2. ip白名单
        3. jwt用户认证
    4. redis常用操作`RedisService`、redis锁`RedisLock`。
3. 接口
    1. 接口数据加密(前台用户系统借鉴gadmin，使用RSA加密)
    2. jwt用户认证
        1. `多表多用户系统隔离`
        2. `jwt-auth`黑名单
4. 后台
    1. 后台用户系统使用casbin实现RBAC
5. 支持切换dev、test、prod环境配置
6. 路由文件的最佳实践😀
7. swagger
8. 支持项目初始化
    1. 数据库迁移工具(本身jwt需要的user表，也需要迁移工具)
    2. 更新goutils等引入拓展包的版本
9. todo: grpc
10. todo: 把prometheus集成进来

