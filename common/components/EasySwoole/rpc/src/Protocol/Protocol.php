<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2023-04-25 16:02:32
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-04-25 16:10:20
 */



namespace EasySwoole\Rpc\Protocol;


class Protocol
{
    public static function pack(string $data): string
    {
        return pack('N', strlen($data)) . $data;
    }

    public static function packDataLength(string $head): int
    {
        return unpack('N', $head)[1];
    }

    public static function unpack(string $data): string
    {
        return substr($data, 4);
    }
}
