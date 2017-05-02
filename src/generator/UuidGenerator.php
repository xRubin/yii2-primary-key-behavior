<?php

namespace rubin\Yii2PrimaryKeyBehavior\generator;

use Yii;
use yii\base\Component;
use rubin\Yii2PrimaryKeyBehavior\KeyGeneratorInterface;

class UuidGenerator extends Component implements KeyGeneratorInterface
{

    /**
     * @return int
     */
    public function getNextId()
    {
    }

    /**
     * @param string $uuid
     * @return string (hex for mysql BINARY(16) column)
     */
    public static function packUuid($uuid)
    {
        assert(strlen($uuid) == 36);

        return pack("h*", str_replace('-', '', $uuid));
    }

    /**
     * @param string $bin
     * @return string
     */
    public static function unpackUuid($bin)
    {
        assert(strlen($bin) == 16);

        $uuid = unpack("h*", $bin);
        $uuid = preg_replace("/([0-9a-f]{8})([0-9a-f]{4})([0-9a-f]{4})([0-9a-f]{4})([0-9a-f]{12})/", "$1-$2-$3-$4-$5", $uuid);
        $uuid = array_merge($uuid);
        return $uuid[0];
    }

    /**
     * @param string $data
     * @return string
     */
    protected function guidV4($data)
    {
        assert(strlen($data) == 16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}