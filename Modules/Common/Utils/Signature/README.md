# api-signature

用api签名来防止重放攻击的中间件

## 使用

可以参考单元测试的测试用例

1. 把指定secret给客户端，用来做salt
2. nonce可以由客户端自己生成
3. sign使用sha256，相比sha1和md5更安全，相比sha3更快
