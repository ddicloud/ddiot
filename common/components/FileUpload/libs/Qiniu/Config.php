<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-13 01:22:15
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-31 13:57:10
 */

namespace Qiniu;

use Qiniu\Zone;

final class Config
{
    const SDK_VER = '7.1.2';

    const BLOCK_SIZE = 4194304; //4*1024*1024 分块上传块大小，该参数为接口规格，不能修改

    const RS_HOST  = 'https://rs.qbox.me';               // 文件元信息管理操作Host
    const RSF_HOST = 'https://rsf.qbox.me';              // 列举操作Host
    const API_HOST = 'https://api.qiniu.com';            // 数据处理操作Host
    const UC_HOST  = 'https://uc.qbox.me';              // Host
    const IO_HOST = '';

    public \Qiniu\Zone $zone;

    public function __construct(Zone $z = null)         // 构造函数，默认为zone0
    {
        // if ($z === null) {
            $this->zone = new Zone();
        // }
    }
}
