<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-07-16 09:18:03
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-16 09:18:18
 */


namespace common\components\sign;

use yii\web\HttpException;

/**
 * MethodNotAllowedHttpException represents a "Sign Not Pass" HTTP exception with status code 403.
 *
 * @see https://tools.ietf.org/html/rfc7231#section-6.5.5
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SignException extends HttpException
{
    /**
     * Constructor.
     * @param int $code error code
     * @param null $message error message
     * @param \Exception|null $previous The previous exception used for the exception chaining.
     */
    public function __construct($code = 0, $message = null, \Exception $previous = null)
    {
        // 未传$message 取错误映射表默认值
        $errorMsg = CodeConst::codeMap()[$code] ?? '';
        $message = $message ?? $errorMsg;
        parent::__construct(403, $message, $code, $previous);
    }
}
