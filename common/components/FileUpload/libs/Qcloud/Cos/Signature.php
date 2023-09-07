<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-13 01:15:38
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-31 13:56:09
 */


namespace Qcloud\Cos;

use Psr\Http\Message\RequestInterface;

class Signature {
    // string: access key.
    private string $accessKey;

    // string: secret key.
    private string $secretKey;

    // bool: host trigger
    private string $signHost;
    /**
     * @var mixed|null
     */
    private mixed $token;
    /**
     * @var array|string[]
     */
    private array $signHeader;

    public function __construct( $accessKey, $secretKey, $signHost, $token = null ) {
        $this->accessKey = $accessKey;
        $this->secretKey = $secretKey;
        $this->signHost = $signHost;
        $this->token = $token;
        $this->signHeader = [
            'cache-control',
            'content-disposition',
            'content-encoding',
            'content-length',
            'content-md5',
            'content-type',
            'expect',
            'expires',
            'host',
            'if-match',
            'if-modified-since',
            'if-none-match',
            'if-unmodified-since',
            'origin',
            'range',
            'response-cache-control',
            'response-content-disposition',
            'response-content-encoding',
            'response-content-language',
            'response-content-type',
            'response-expires',
            'transfer-encoding',
            'versionid',
        ];
        date_default_timezone_set( 'PRC' );
    }

    public function __destruct() {
    }

    public function needCheckHeader( $header ): bool
    {
        if ( startWith( $header, 'x-cos-' ) ) {
            return true;
        }
        if ( in_array( $header, $this->signHeader ) ) {
            return true;
        }
        return false;
    }

    public function signRequest( RequestInterface $request ): RequestInterface
    {
        $authorization = $this->createAuthorization( $request );
        return $request->withHeader( 'Authorization', $authorization );
    }

    public function createAuthorization( RequestInterface $request, $expires = '+30 minutes' ): string
    {
        if ( is_null( $expires ) || !strtotime( $expires )) {
            $expires = '+30 minutes';
        }
        $signTime = ( string )( time() - 60 ) . ';' . ( string )( strtotime( $expires ) );
        $urlParamListArray = [];
        foreach ( explode( '&', $request->getUri()->getQuery() ) as $query ) {
            if (!empty($query)) {
                $tmpquery = explode( '=', $query );
                $key = strtolower( $tmpquery[0] );
                if (count($tmpquery) >= 2) {
                    $value = $tmpquery[1];
                } else {
                    $value = "";
                }
                //host开关
                if (!$this->signHost && $key == 'host') {
                    continue;
                }
                $urlParamListArray[$key] = $key. '='. $value;
            }
        }
        ksort($urlParamListArray);
        $urlParamList = join(';', array_keys($urlParamListArray));
        $httpParameters = join('&', array_values($urlParamListArray));

        $headerListArray = [];
        foreach ( $request->getHeaders() as $key => $value ) {
            $key = strtolower( urlencode( $key ) );
            $value = rawurlencode( $value[0] );
            if ( !$this->signHost && $key == 'host' ) {
                continue;
            }
            if ( $this->needCheckHeader( $key ) ) {
                $headerListArray[$key] = $key. '='. $value;
            }
        }
        ksort($headerListArray);
        $headerList = join(';', array_keys($headerListArray));
        $httpHeaders = join('&', array_values($headerListArray));
        $httpString = strtolower( $request->getMethod() ) . "\n" . urldecode( $request->getUri()->getPath() ) . "\n" . $httpParameters.
        "\n". $httpHeaders. "\n";
        $sha1edHttpString = sha1( $httpString );
        $stringToSign = "sha1\n$signTime\n$sha1edHttpString\n";
        $signKey = hash_hmac( 'sha1', $signTime, trim($this->secretKey) );
        $signature = hash_hmac( 'sha1', $stringToSign, $signKey );
        return 'q-sign-algorithm=sha1&q-ak='. trim($this->accessKey) .
        "&q-sign-time=$signTime&q-key-time=$signTime&q-header-list=$headerList&q-url-param-list=$urlParamList&" .
        "q-signature=$signature";
    }

    public function createPresignedUrl( RequestInterface $request, $expires = '+30 minutes' ): \Psr\Http\Message\UriInterface
    {
        $authorization = $this->createAuthorization( $request, $expires);
        $uri = $request->getUri();
        $query = 'sign='.urlencode( $authorization ) . '&' . $uri->getQuery();
        if ( $this->token != null ) {
            $query = $query.'&x-cos-security-token='.$this->token;
        }
        $uri = $uri->withQuery( $query );
        return $uri;
    }
}
