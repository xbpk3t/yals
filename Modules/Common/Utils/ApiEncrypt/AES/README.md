# aes-encrypt

参考了部分[Laravel 实现 API 通讯数据的加解密 | Laravel China 社区](https://learnku.com/articles/17424)中的代码，加密数据改为用后置中间件实现。服务端和客户端都需要一次先解密再加密的过程。


使用方法：

1. 服务端的加密解密方法已实现，不多说。
2. 重点是客户端需要按照服务端的实现，用对应语言实现一下加密解密的方法。客户端对返回值，直接base64_decode()，可以返回`iv偏移量`、`value`、`MAC`。之后会用js写一个


ios下可以参考[Laravel 构建一个AES密码登录的接口，并在iOS下对接 - 简书](https://www.jianshu.com/p/de6ec3039622)这个帖子。



{"iv":"K/9KiTKr1L42HQBE3aMknw==","value":"Ain029a3zgaJNcNdGreBIViTCALHz+EYto6sJhHAqeGltaaO1pVwYXzOTd2Q9iu9NtJcn/i4C6w2EKEZEMmQZw==","mac":"a59795c14fb1953c50683a079dacda56445d7fc033d33107df552071ac2d0ef5"}


{"iv":"LZ1Sc2W0QbHFD0flHhYzEw==","value":"39a9PAwtWTTUtIQNY04B06yIVy7s366uHHAp6T/JF3q1RPz0szj8mspE09NvwUUIjt5+GfoSEUwjA4W8aGyUSg==","mac":"103d12b853d652a4e54d6670b8d98aa63df39addd34dfdde702fd339fb1e61aa"}
