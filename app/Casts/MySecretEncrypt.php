<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Encryption\Encrypter;
use Exception;

class MySecretEncrypt implements CastsAttributes
{
    protected $encrypter;

    public function __construct()
    {
        // ดึงรหัสจาก .env
        $key = $this->normalizeKey(config('app.my_secret_key'));
        $cipher = config('app.my_secret_cipher', 'AES-256-GCM');

        $previousKeys = config('app.my_secret_previous_keys', []);
        if (is_string($previousKeys)) {
            $previousKeys = array_filter(explode(',', $previousKeys));
        }

        $previousKeys = array_map(function ($previousKey) {
            return $this->normalizeKey($previousKey);
        }, $previousKeys);

        // สร้างตัวเข้ารหัสด้วยกุญแจของคุณเอง
        $this->encrypter = new Encrypter($key, $cipher, $previousKeys);
    }

    private function normalizeKey($key): string
    {
        $key = (string) $key;
        if ($key === '') {
            throw new Exception('MY_SECRET_KEY ไม่ได้ถูกกำหนด');
        }

        if (str_starts_with($key, 'base64:')) {
            $decoded = base64_decode(substr($key, 7), true);
            if ($decoded === false) {
                throw new Exception('MY_SECRET_KEY ไม่ถูกต้อง (base64)');
            }
            $key = $decoded;
        }

        if (strlen($key) !== 32) {
            throw new Exception('MY_SECRET_KEY ต้องมีความยาว 32 ไบต์เท่านั้น');
        }

        return $key;
    }

    /**
     * ขาเข้า (Get): ดึงจาก Database -> ถอดรหัสมาโชว์
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if ($value === null) {
            return $value;
        }

        try {
            // ถอดรหัส
            return $this->encrypter->decryptString($value);
        } catch (Exception $e) {
            throw new DecryptException('ไม่สามารถถอดรหัสข้อมูลได้');
        }
    }

    /**
     * ขาออก (Set): รับจาก Form -> เข้ารหัสก่อนลง Database
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if ($value === null) {
            return $value;
        }

        // เข้ารหัส
        return $this->encrypter->encryptString((string) $value);
    }
}
