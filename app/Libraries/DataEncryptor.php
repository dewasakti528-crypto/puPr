<?php
namespace App\Libraries;

use Exception;

class DataEncryptor
{
    private string $cipher = 'AES-128-CBC';
    private string $encKey;     // untuk AES (binary)
    private string $hmacKey;    // untuk HMAC-SHA256 (binary)

    public function __construct()
    {
        // Ambil dari .env
        $encKeyRaw  = getenv('ENCRYPTION_KEY') ?: '';
        $hmacKeyRaw = getenv('HMAC_KEY') ?: '';

        if (empty($encKeyRaw) || empty($hmacKeyRaw)) {
            throw new Exception('ENCRYPTION_KEY dan HMAC_KEY harus diset di .env');
        }

        // Untuk AES-128 kita butuh 16 bytes key
        $this->encKey  = substr(hash('sha256', $encKeyRaw, true), 0, 16);
        // Untuk HMAC kita gunakan kunci lengkap (bisa hasil hash juga)
        $this->hmacKey = hash('sha256', $hmacKeyRaw, true);
    }

    /**
     * Encrypt dengan AES-128-CBC + IV random. Return base64(iv . cipher)
     */
    public function encrypt(string $plaintext): string
    {
        $ivLen = openssl_cipher_iv_length($this->cipher);
        $iv = random_bytes($ivLen);

        $cipherRaw = openssl_encrypt($plaintext, $this->cipher, $this->encKey, OPENSSL_RAW_DATA, $iv);
        if ($cipherRaw === false) {
            throw new Exception('Encrypt gagal');
        }

        // Prefix IV agar bisa didecrypt
        $combined = $iv . $cipherRaw;
        return base64_encode($combined);
    }

    /**
     * Decrypt dari base64(iv . cipher) -> plaintext
     */
    public function decrypt(string $b64): string
    {
        $data = base64_decode($b64, true);
        if ($data === false) {
            throw new Exception('Data bukan base64 valid');
        }

        $ivLen = openssl_cipher_iv_length($this->cipher);
        if (strlen($data) < $ivLen) {
            throw new Exception('Data cipher terlalu pendek (tidak berisi IV)');
        }

        $iv = substr($data, 0, $ivLen);
        $cipherRaw = substr($data, $ivLen);

        $plain = openssl_decrypt($cipherRaw, $this->cipher, $this->encKey, OPENSSL_RAW_DATA, $iv);
        if ($plain === false) {
            throw new Exception('Decrypt gagal - kemungkinan kunci salah atau data korup');
        }

        return $plain;
    }

    /**
     * HMAC-SHA256 hex string (64 chars) untuk keperluan pencarian deterministik.
     * Gunakan HMAC dengan kunci rahasia (tidak boleh publik).
     */
    public function hmac(string $plaintext): string
    {
        return hash_hmac('sha256', $plaintext, $this->hmacKey);
    }

    /**
     * Helper: validasi apakah ciphertext base64 tampak valid (tidak ketik)
     */
    public function isValidBase64(string $s): bool
    {
        $decoded = base64_decode($s, true);
        if ($decoded === false) return false;
        // optional: check length >= ivLen
        return strlen($decoded) >= openssl_cipher_iv_length($this->cipher);
    }

    public function encodeUriToken($data) : string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    
    public function decodeUriToken($token) : string
    {
        return base64_decode(str_pad(strtr($token, '-_', '+/'), 
                                    strlen($token) % 4, 
                                    '=', 
                                    STR_PAD_RIGHT));
    }
}
