<?php

namespace Omnipay\CryptoCloud\Message;

use Omnipay\Common\Message\AbstractRequest as Request;

abstract class AbstractRequest extends Request
{

    protected $method = "";
    protected $productionUri = "";
    protected $testUri       = "";

    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->testUri : $this->productionUri;
    }

    public function setHeaders($value) {
        return $this->setParameter('headers',$value);
    }

    public function getHeaders() {
        return $this->getParameter('headers');
    }

    public function setShopId($value)
    {
        return $this->setParameter("shop_id", $value);
    }

    public function getShopId()
    {
        return $this->getParameter("shop_id");
    }
    public function setEmail($value)
    {
        return $this->setParameter("email", $value);
    }

    public function getEmail()
    {
        return $this->getParameter("email");
    }

    public function setApiKey($value)
    {
        return $this->setParameter("apiKey",$value);
    }

    public function getApiKey()
    {
        return $this->getParameter("apiKey");
    }

    public function send()
    {
        $data = $this->getData();

        $response = $this->getClient($data);

        $result = json_decode($response->getBody()->getContents(),1);

        return $this->sendData($result);
    }

    protected function getClient($data)
    {
        return $this->httpClient->request(
          $this->method,
          $this->getEndpoint(),
          $this->getHeaders(), 
          http_build_query($data)
        );
    }

}
