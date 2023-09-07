<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-13 01:15:38
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-31 13:56:11
 */


namespace Qcloud\Cos;

use Psr\Http\Message\RequestInterface;

class SignatureMiddleware {
    private $nextHandler;
    protected Signature $signature;

    /**
     * @param callable $nextHandler Next handler to invoke.
     */
    public function __construct(callable $nextHandler, $accessKey, $secretKey, $signHost) {
        $this->nextHandler = $nextHandler;
        $this->signature = new Signature($accessKey, $secretKey, $signHost);
    }

    public function __invoke(RequestInterface $request, array $options) {
        $fn = $this->nextHandler;
        return $fn($this->signature->signRequest($request), $options);
	}
}
