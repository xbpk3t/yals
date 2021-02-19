<?php

namespace Modules\Common\Utils\ApiEncrypt\RSA;

class RSA
{
    // Minimum key size bits
    const MINIMUM_KEY_SIZE = 128;

    // Default key size bits
    const DEFAULT_KEY_SIZE = 2048;

    protected $publicKeyFile;
    protected $privateKeyFile;
    protected $password;

    public function __construct($publicKeyFile, $privateKeyFile = null, $password = null)
    {
        $this->publicKeyFile = $this->fixKeyArgument($publicKeyFile);
        $this->privateKeyFile = $this->fixKeyArgument($privateKeyFile);
        $this->password = $password;
    }

    public function fixKeyArgument($keyFile)
    {
        if (0 === mb_strpos($keyFile, '/')) {
            // This looks like a path, let us prepend the file scheme
            return 'file://' . $keyFile;
        }

        return $keyFile;
    }

    /**
     * Creates a new RSA key pair with the given key size.
     *
     * @param null $keySize   RSA Key Size in bits
     * @param bool $overwrite Overwrite existing key files
     *
     * @throws RSAException
     *
     * @return bool Result of creation
     */
    public function create($keySize = null, $overwrite = false)
    {
        $keySize = intval($keySize);
        if ($keySize < self::MINIMUM_KEY_SIZE) {
            $keySize = self::DEFAULT_KEY_SIZE;
        }

        if (!$overwrite) {
            if (
                (0 === mb_strpos($this->publicKeyFile, 'file://') && file_exists($this->publicKeyFile)) ||
                (0 === mb_strpos($this->privateKeyFile, 'file://') && file_exists($this->privateKeyFile))
            ) {
                throw new RSAException('OpenSSL: Existing keys found. Remove keys or pass $overwrite == true.');
            }
        }

        $resource = openssl_pkey_new([
            'private_key_bits' => $keySize,
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
        ]);

        $publicKey = openssl_pkey_get_details($resource)['key'];
        if (0 === mb_strpos($this->publicKeyFile, 'file://')) {
            $bytes = file_put_contents($this->publicKeyFile, $publicKey);
        } else {
            $this->publicKeyFile = $publicKey;
            $bytes = mb_strlen($publicKey);
        }
        if (mb_strlen($publicKey) < 1 || $bytes != mb_strlen($publicKey)) {
            throw new RSAException('OpenSSL: Error writing PUBLIC key.');
        }

        $privateKey = '';
        openssl_pkey_export($resource, $privateKey, $this->password);
        if (0 === mb_strpos($this->privateKeyFile, 'file://')) {
            $bytes = file_put_contents($this->privateKeyFile, $privateKey);
        } else {
            $this->privateKeyFile = $privateKey;
            $bytes = mb_strlen($privateKey);
        }
        if (mb_strlen($privateKey) < 1 || $bytes != mb_strlen($privateKey)) {
            throw new RSAException('OpenSSL: Error writing PRIVATE key.');
        }

        openssl_pkey_free($resource);

        return true;
    }

    /**
     * Get public key to be used during encryption and decryption.
     *
     * @return string Certificate public key string or stream path
     */
    public function getPublicKeyFile()
    {
        return $this->publicKeyFile;
    }

    /**
     * Get private key to be used during encryption and decryption.
     *
     * @return string Certificate private key string or stream path
     */
    public function getPrivateKeyFile()
    {
        return $this->privateKeyFile;
    }

    /**
     * Set password to be used during encryption and decryption.
     *
     * @param string $password Certificate password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Encrypt data with provided public certificate.
     *
     * @param string $data Data to encrypt
     *
     * @throws RSAException
     *
     * @return string Encrypted data
     */
    public function encrypt($data)
    {
        // Load public key
        $publicKey = openssl_pkey_get_public($this->publicKeyFile);

        if (!$publicKey) {
            throw new RSAException('OpenSSL: Unable to get public key for encryption. Is the location correct? Does this key require a password?');
        }

        $success = openssl_public_encrypt($data, $encryptedData, $publicKey);
        openssl_free_key($publicKey);
        if (!$success) {
            throw new RSAException('Encryption failed. Ensure you are using a PUBLIC key.');
        }

        return $encryptedData;
    }

    /**
     * Encrypt data and then base64_encode it.
     *
     * @param string $data Data to encrypt
     *
     * @return string Base64-encrypted data
     */
    public function base64Encrypt($data)
    {
        return base64_encode($this->encrypt($data));
    }

    /**
     * Decrypt data with provided private certificate.
     *
     * @param string $data Data to encrypt
     *
     * @throws RSAException
     *
     * @return string Decrypted data
     */
    public function decrypt($data)
    {
        if (null === $this->privateKeyFile) {
            throw new RSAException('Unable to decrypt: No private key provided.');
        }

        $privateKey = openssl_pkey_get_private($this->privateKeyFile, $this->password);
        if (!$privateKey) {
            throw new RSAException('OpenSSL: Unable to get private key for decryption. Is the location correct? If this key requires a password, have you supplied the correct one?');
        }

        $success = openssl_private_decrypt($data, $decryptedData, $privateKey);
        openssl_free_key($privateKey);
        if (!$success) {
            throw new RSAException('Decryption failed. Ensure you are using (1) a PRIVATE key, and (2) the correct one.');
        }

        return $decryptedData;
    }

    /**
     * base64_decode data and then decrypt it.
     *
     * @param string $data Base64-encoded data to decrypt
     *
     * @return string Decrypted data
     */
    public function base64Decrypt($data)
    {
        return $this->decrypt(base64_decode($data));
    }
}
