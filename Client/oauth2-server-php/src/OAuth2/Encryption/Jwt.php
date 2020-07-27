<?php

namespace OAuth2\Encryption;

use Exception;
use InvalidArgumentException;

/**
 * @link https://github.com/F21/jwt
 * @author F21
 */
class Jwt implements EncryptionInterface
{
    /**
     * @param $payload
     * @param $key
     * @param string $algo
     * @return string
     */
    public function encode($payload, $key, $algo = 'HS256')
    {
        $header = $this->generateJwtHeader($payload, $algo);

        $segments = array(
            $this->urlSafeB64Encode(json_encode($header)),
            $this->urlSafeB64Encode(json_encode($payload))
        );

        $signing_input = implode('.', $segments);

        $signature = $this->sign($signing_input, $key, $algo);
        $segments[] = $this->urlsafeB64Encode($signature);

        return implode('.', $segments);
    }

    /**
     * @param string      $jwt
     * @param null        $key
     * @param array|bool  $allowedAlgorithms
     * @return bool|mixed
     */
    public function decode($jwt, $key = null, $allowedAlgorithms = true)
    {
        if (!strpos($jwt, '.')) {
            return false;
        }

        $tks = explode('.', $jwt);

        if (count($tks) != 3) {
            return false;
        }

        list($headb64, $payloadb64, $cryptob64) = $tks;

        if (null === ($header = json_decode($this->urlSafeB64Decode($headb64), true))) {
            return false;
        }

        if (null === $payload = json_decode($this->urlSafeB64Decode($payloadb64), true)) {
            return false;
        }

        $sig = $this->urlSafeB64Decode($cryptob64);

        if ((bool) $allowedAlgorithms) {
            if (!isset($header['alg'])) {
                return false;
            }

            // check if bool arg supplied here to maintain BC
            if (is_array($allowedAlgorithms) && !in_array($header['alg'], $allowedAlgorithms)) {
                return false;
            }

            if (!$this->verifySignature($sig, "$headb64.$payloadb64", $key, $header['alg'])) {
                return false;
            }
        }

        return $payload;
    }

    /**
     * @param $signature
     * @param $input
     * @param $key
     * @param string $algo
     * @return bool
     * @throws InvalidArgumentException
     */
    private function verifySignature($signature, $input, $key, $algo = 'HS256')
    {
        $file = fopen("oauth2-server-php/test/config/keys/id_rsa.pub", 'r');
        $key_correct_format = "";
        while ($line = fgets($file)){
            $key_correct_format .= $line;
        }
       
        switch ($algo) {
            case'HS256':
            case'HS384':
            case'HS512':
                return $this->hash_equals(
                    $this->sign($input, $key_correct_format, $algo),
                    $signature
                );

            case 'RS256':
                return openssl_verify($input, $signature, $key_correct_format, defined('OPENSSL_ALGO_SHA256') ? OPENSSL_ALGO_SHA256 : 'sha256')  === 1;

            case 'RS384':
                return @openssl_verify($input, $signature, $key_correct_format, defined('OPENSSL_ALGO_SHA384') ? OPENSSL_ALGO_SHA384 : 'sha384') === 1;

            case 'RS512':
                return @openssl_verify($input, $signature, $key_correct_format, defined('OPENSSL_ALGO_SHA512') ? OPENSSL_ALGO_SHA512 : 'sha512') === 1;

            default:
                throw new InvalidArgumentException("Unsupported or invalid signing algorithm.");
        }
    }

    /**
     * @param $input
     * @param $key
     * @param string $algo
     * @return string
     * @throws Exception
     */
    private function sign($input, $key, $algo = 'HS256')
    {
        switch ($algo) {
            case 'HS256':
                return hash_hmac('sha256', $input, $key, true);

            case 'HS384':
                return hash_hmac('sha384', $input, $key, true);

            case 'HS512':
                return hash_hmac('sha512', $input, $key, true);

            case 'RS256':
                return $this->generateRSASignature($input, $key, defined('OPENSSL_ALGO_SHA256') ? OPENSSL_ALGO_SHA256 : 'sha256');

            case 'RS384':
                return $this->generateRSASignature($input, $key, defined('OPENSSL_ALGO_SHA384') ? OPENSSL_ALGO_SHA384 : 'sha384');

            case 'RS512':
                return $this->generateRSASignature($input, $key, defined('OPENSSL_ALGO_SHA512') ? OPENSSL_ALGO_SHA512 : 'sha512');

            default:
                throw new Exception("Unsupported or invalid signing algorithm.");
        }
    }

    /**
     * @param $input
     * @param $key
     * @param string $algo
     * @return mixed
     * @throws Exception
     */
    private function generateRSASignature($input, $key, $algo)
    {
        $file = fopen("oauth2-server-php/test/config/keys/id_rsa", 'r');
        $key_correct_format = "";
        while ($line = fgets($file)){
            $key_correct_format .= $line;
        }
          /*$key1 = "-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQC8fpi06NfVYHAOAnxNMVnTXr/ptsLsNjP+uAt2eO0cc5J9H5XV
8lFVujOrRu/JWi1TDmAvOaf/6A3BphIA1Pwp0AAqlZdwizIum8j0KzpsGYH5qReN
QDwF3oUSKMsQCCGCDHrDYifG/pRi9bN1ZVjEXPr35HJuBe+FQpZTs8DewwIDAQAB
AoGARfNxNknmtx/n1bskZ/01iZRzAge6BLEE0LV6Q4gS7mkRZu/Oyiv39Sl5vUlA
+WdGxLjkBwKNjxGN8Vxw9/ASd8rSsqeAUYIwAeifXrHhj5DBPQT/pDPkeFnp9B1w
C6jo+3AbBQ4/b0ONSIEnCL2xGGglSIAxO17T1ViXp7lzXPECQQDe63nkRdWM0OCb
oaHQPT3E26224maIstrGFUdt9yw3yJf4bOF7TtiPLlLuHsTTge3z+fG6ntC0xG56
1cl37C3ZAkEA2HdVcRGugNp/qmVz4LJTpD+WZKi73PLAO47wDOrYh9Pn2I6fcEH0
CPnggt1ko4ujvGzFTvRH64HXa6aPCv1j+wJBAMQMah3VQPNf/DlDVFEUmw9XeBZg
VHaifX851aEjgXLp6qVj9IYCmLiLsAmVa9rr6P7p8asD418nZlaHUHE0eDkCQQCr
uxis6GMx1Ka971jcJX2X696LoxXPd0KsvXySMupv79yagKPa8mgBiwPjrnK+EPVo
cj6iochA/bSCshP/mwFrAkBHEKPi6V6gb94JinCT7x3weahbdp6bJ6/nzBH/p9VA
HoT1JtwNFhGv9BCjmDydshQHfSWpY9NxlccBKL7ITm8R
-----END RSA PRIVATE KEY-----";*/
        if (!openssl_sign($input, $signature, $key_correct_format, $algo)) {
            throw new Exception("Unable to sign data.");
        }

        return $signature;
    }

    /**
     * @param string $data
     * @return string
     */
    public function urlSafeB64Encode($data)
    {
        $b64 = base64_encode($data);
        $b64 = str_replace(array('+', '/', "\r", "\n", '='),
                array('-', '_'),
                $b64);

        return $b64;
    }

    /**
     * @param string $b64
     * @return mixed|string
     */
    public function urlSafeB64Decode($b64)
    {
        $b64 = str_replace(array('-', '_'),
                array('+', '/'),
                $b64);

        return base64_decode($b64);
    }

    /**
     * Override to create a custom header
     */
    protected function generateJwtHeader($payload, $algorithm)
    {
        return array(
            'typ' => 'JWT',
            'alg' => $algorithm,
        );
    }

    /**
     * @param string $a
     * @param string $b
     * @return bool
     */
    protected function hash_equals($a, $b)
    {
        if (function_exists('hash_equals')) {
            return hash_equals($a, $b);
        }
        $diff = strlen($a) ^ strlen($b);
        for ($i = 0; $i < strlen($a) && $i < strlen($b); $i++) {
            $diff |= ord($a[$i]) ^ ord($b[$i]);
        }

        return $diff === 0;
    }
}