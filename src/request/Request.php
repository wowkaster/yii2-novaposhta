<?php
namespace jones\novaposhta\request;

use jones\novaposhta\converters\ConverterInterface;
use jones\novaposhta\http\ClientFactory;

/**
 * Class Request
 */
class Request implements RequestInterface
{
    const API_URL_XML = 'https://api.novaposhta.ua/v2.0/xml/';

    const API_URL_JSON = 'https://api.novaposhta.ua/v2.0/json/';

    /**
     * Request data converter
     * @var \jones\novaposhta\converters\ConverterInterface
     */
    private $converter;

    /**
     * Factory to create http client
     * @var \jones\novaposhta\http\ClientFactory
     */
    private $factory;

    /**
     * API key
     * @var string
     */
    private $apiKey;

    /**
     * Encoded data to need format
     * @var string
     */
    private $body;

    /**
     * Options for request
     * @var array
     */
    private $options;

    /**
     * Init request object
     * @param ConverterInterface $converter
     * @param ClientFactory $factory
     * @param string $apiKey
     */
    public function __construct(ConverterInterface $converter, ClientFactory $factory, $apiKey)
    {
        $this->converter = $converter;
        $this->factory = $factory;
        $this->apiKey = $apiKey;
    }

    /**
     * @inheritdoc
     */
    public function build($modelName, $calledMethod, array $params)
    {
        $data = [
            'apiKey' => $this->apiKey,
            'modelName' => $modelName,
            'calledMethod' => $calledMethod,
        ];
        if (!empty($params)) {
            $data['methodProperties'] = $params;
        }
        $this->body = $this->converter->encode($data);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        $client = $this->factory->create();
        $response = $client->execute($this, $this->converter->getContentType(), $this->getUrl(), $this->getOptions());
        return $this->converter->decode($response);
    }

    /**
     * @inheritdoc
     */
    public function getBody()
    {
        return $this->body;
    }

    public function setOptions(array $options){
        $this->options = $options;
        return $this;
    }

    public function getOptions(){
        return $this->options;
    }

    /**
     * Return url to api calls
     * @return string
     */
    protected function getUrl()
    {
        if ($this->converter->getType() == ConverterInterface::FORMAT_XML) {
            return self::API_URL_XML;
        } else {
            return self::API_URL_JSON;
        }
    }
}
