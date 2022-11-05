<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-02-21 10:06:15
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-11-02 15:14:40
 */

namespace common\helpers;

use Hashids\Hashids;
use yii\web\UnprocessableEntityHttpException;

class HashidsHelper
{
    /**
     * 长度.
     *
     * @var int
     */
    public static $lenght = 5;

    /**
     * 为安全起见需要修改为自己的秘钥.
     *
     * @var string
     */
    public static $secretKey = 'tuEIGF42FW9Xrxxe0PvA65f1aEhURs4J';

    /**
     * @var \Hashids\Hashids
     */
    protected static $hashids;

    /**
     * 加密.
     *
     * @param mixed ...$numbers
     *
     * @return string
     */
    public static function encode(...$numbers)
    {
        return self::getHashids()->encode(...$numbers);
    }

    /**
     * 解密.
     *
     * @return array
     *
     * @throws UnprocessableEntityHttpException
     */
    public static function decode(string $hash)
    {
        $data = self::getHashids()->decode($hash);
        if (empty($data) || !is_array($data)) {
            throw new UnprocessableEntityHttpException('解密失败');
        }

        return count($data) == 1 ? $data[0] : $data;
    }

    /**
     * @return Hashids
     */
    private static function getHashids()
    {
        if (!self::$hashids instanceof Hashids) {
            self::$hashids = new Hashids(self::$secretKey, self::$lenght); // all lowercase
        }

        return self::$hashids;
    }
}
