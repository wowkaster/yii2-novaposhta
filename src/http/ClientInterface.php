<?php
namespace jones\novaposhta\http;

use jones\novaposhta\request\RequestInterface;

/**
 * Interface ClientInterface
 */
interface ClientInterface
{
    /**
     * Execute http request
     * @param RequestInterface $request
     * @param string $contentType
     * @param string $url
     * @param array $options
     * @return string
     */
    public function execute(RequestInterface $request, $contentType, $url, $options=[]);
}
