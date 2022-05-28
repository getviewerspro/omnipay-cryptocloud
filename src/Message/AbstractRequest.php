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

    /**
     * Send data to the remote gateway, parse the result into an array,
     * then use that to instantiate the response object.
     *
     * @param  array
     * @return Response The reponse object initialised with the data returned from the gateway.
     */
    public function sendData($data)
    {
        // Issue #20 no data values should be null.

        array_walk($data, function (&$value) {
            if (! isset($value)) {
                $value = '';
            }
        });

        $httpResponse = $this
            ->httpClient
            ->request(
                'POST',
                $this->getEndpoint(),
                [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                http_build_query($data)
            );

        // We might want to check $httpResponse->getStatusCode()

        $responseData = static::parseBodyData($httpResponse);

        return $this->createResponse($responseData);
    }

    protected function getClient($data)
    {
        return $this->httpClient->request(
          $this->method,
          $this->getEndpoint(),
          $this->getHeaders(),
          json_encode($data)
        );
    }

}
