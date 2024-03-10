<?php

namespace Shibanashiqc\NboPaymentGatewayPhp;

class Decrypt
{
    /**
     * decryptAES
     *
     * @param  mixed $todecrypt
     * @param  mixed $key
     * @return string
     */
    public static function decryptAES($todecrypt, $key): string
    {
        $algorithm = 'AES-256-CBC';
        $iv = 'PGKEYENCDECIVSPC';
        $todecrypt = self::hex2ByteArray(trim($todecrypt));
        $todecrypt = self::byteArray2String($todecrypt);
        $decrypted = openssl_decrypt($todecrypt, $algorithm, $key, OPENSSL_RAW_DATA, $iv);
        return urldecode($decrypted);
    }

    /**
     * hex2ByteArray
     *
     * @param  mixed $hexString
     * @return array
     */
    private static function hex2ByteArray($hexString): array
    {
        $string = hex2bin($hexString);
        return unpack('C*', $string);
    }
    /**
     * byteArray2String
     *
     * @param  mixed $byteArray
     * @return mixed
     */
    private static function byteArray2String($byteArray): mixed
    {
        $chars = array_map("chr", $byteArray);
        return join($chars);
    }
}
