<?php

namespace Omnipay\CryptoCloud\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class InvoiceRequest extends AbstractRequest
{
    protected $method     = 'POST';
    public $productionUri = "https://cryptocloud.plus/api/v2/invoice/create";
    public $testUri       = "https://cryptocloud.plus/api/v2/invoice/create";

    /**
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate(
            'shop_id',
            'amount'
        );

        $this->prepareRequest();

        return $this->prepareRequestBody();
    }

    public function setHeader($value)
    {
        return $this->setParameter('header',$value);
    }

    public function getHeader()
    {
        return $this->getParameter("header");
    }

    public function sendData($result)
    {
        return $this->response = new InvoiceResponse($this,$result);
    }

    private function prepareRequest()
    {
        $this->setHeaders([
            "Authorization" => 'Token '.$this->getApiKey()
        ]);

        return $this;
    }

    private function prepareRequestBody()
    {
        $data = $this->parameters->all();

        info($data);

        return [
            'shop_id' => $data['shop_id'],
            'amount' => $data['amount'],
            'order_id' => $data['transactionId'],
            'email' => $data['email'],
            'currency' => $data['currency'],
        ];
    }

}
