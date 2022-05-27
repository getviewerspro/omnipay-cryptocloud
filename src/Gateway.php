<?php

namespace Omnipay\CryptoCloud;

use Omnipay\CryptoCloud\Message\CompletePurchaseRequest;
use Omnipay\Common\AbstractGateway;
use Omnipay\CryptoCloud\Message\InvoiceRequest;


class Gateway extends AbstractGateway
{

    public function getName()
    {
        return "CryptoCloud";
    }

    public function getDefaultParameters()
    {
        return [
        ];
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
        return $this->setParameter("apiKey", $value);
    }

    public function getApiKey()
    {
        return $this->getParameter("apiKey");
    }

    public function createInvoice(array $options = [])
    {
        return $this->createRequest(InvoiceRequest::class, $options);
    }

    /**
        Alias for createInvoice
     */
    public function purchase(array $options = array()): \Omnipay\Common\Message\RequestInterface
    {
        return $this->createInvoice($options);
    }

    public function completePurchase(array $options = array()): \Omnipay\Common\Message\RequestInterface
    {
        return $this->createRequest(CompletePurchaseRequest::class, $options);
    }
}
