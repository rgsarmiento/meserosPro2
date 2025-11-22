<?php

namespace App\Services;

class DesEncryption
{
    private const SECRET_KEY = '$N0D0$';

    public static function encrypt(string $stringToEncrypt, string $pin = ''): string
    {
        $key = md5($pin . self::SECRET_KEY, true);
        
        // Padding PKCS7 manual (bloques de 8 bytes para 3DES)
        $blockSize = 8;
        $padLength = $blockSize - (strlen($stringToEncrypt) % $blockSize);
        $stringToEncrypt .= str_repeat(chr($padLength), $padLength);
        
        $encrypted = openssl_encrypt(
            $stringToEncrypt,
            'DES-EDE3-ECB',
            $key,
            OPENSSL_RAW_DATA | OPENSSL_NO_PADDING
        );
        
        return base64_encode($encrypted);
    }

    public static function decrypt(string $encryptedString, string $pin = ''): string
    {
        try {
            $key = md5($pin . self::SECRET_KEY, true);
            
            $decrypted = openssl_decrypt(
                base64_decode($encryptedString),
                'DES-EDE3-ECB',
                $key,
                OPENSSL_RAW_DATA | OPENSSL_NO_PADDING
            );
            
            // Remover padding PKCS7
            $padLength = ord($decrypted[strlen($decrypted) - 1]);
            return substr($decrypted, 0, -$padLength);
        } catch (\Exception $e) {
            return 'na';
        }
    }
}
