<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-13 01:14:45
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-01-03 09:36:28
 */

namespace Local;

use common\helpers\ArrayHelper;
use common\helpers\FileHelper;
use common\helpers\ResultHelper;
use common\helpers\StringHelper;

class LocalCor
{
    // 文件名称
    public string $file_name;
    // 文件类型
    public string $file_type;
    // 文件总大小
    public int $file_size;

    /**
     * @throws LocalException
     */
    public function __construct($file_name, $file_size, $file_type)
    {
        if (empty($file_name)) {
            throw new LocalException('文件名称不能为空');
        }

        if (empty($file_size)) {
            throw new LocalException('文件大小不能为空');
        }

        $this->file_name = $file_name;
        $this->file_size = $file_size;
        $this->file_type = $file_type;
    }

    // 合并本地分片
    //  'file' => $file,
    //  // 分片存放目录
    //  'temDir' => $uploadTempDir,
    //  // 分片大小
    //  'chunk_partSize' => (int) $chunk_partSize,
    //  // 分片总数
    //  'chunk_partCount' => (int) $chunk_partCount,
    //  // 分片序号
    //  'chunk_partIndex' => (int) $chunk_partIndex,
    //  'md5' => $md5,
    //  'chunk_md5' => $chunk_md5,
    public function mergeParts($PartList, $path): array|string
    {
        $file_name = $this->file_name;
        list($name, $ext) = explode('.', $file_name);
        $part_list = json_decode($PartList, true);
        // $rand_name = StringHelper::uuid('uniqid');
        $rand_name = rand(1000, 9999);
        // $file = $path.'/'.$rand_name.'.'.$ext;
        $file = $path.'/'.$rand_name.$file_name;
        if (!is_array($part_list)) {
            return ResultHelper::serverJson(400, '分片数据不是标准的json数据');
        }

        if (!is_dir($path)) {
            FileHelper::mkdirs($path);
        }
        $temDir = '';
        // 对分片进行排序
        $part_lists = ArrayHelper::arraySort($part_list, 'chunk_partIndex');
        foreach ($part_lists as $key => $value) {
            $content = file_get_contents($value['file']);
            file_put_contents($file, $content, FILE_APPEND);
            FileHelper::file_delete($value['file']);
            $temDir = $value['temDir'];
        }

        $file_lists = FileHelper::file_lists($temDir);
        if (is_dir($temDir) && empty($file_lists)) {
            // 删除该文件
            FileHelper::rmdirs(rtrim($temDir, '/'));
        }

        return $file;
    }
}
