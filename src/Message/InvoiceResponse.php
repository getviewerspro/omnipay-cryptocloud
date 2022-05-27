<?php

namespace Omnipay\CryptoCloud\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class InvoiceResponse extends AbstractResponse implements RedirectResponseInterface
{

    public function isSuccessful()
    {

        $result = false;

        if (isset($this->data['result'])) {
            if ($this->data['result'] == 'success') {
                $result = true;
            }
        }

        return $result;

    }

    public function getInvoiceId()
    {
        return $this->data['invoice_id'];
    }

    public function getInvoiceLink()
    {
        return $this->data['pay_url'];
    }

    public function getMessage()
    {

        return $this->data;

    }
    
    public function isRedirect()
    {
        return true;
    }

    public function getRedirectUrl()
    {
        return $this->getInvoiceLink();
    }

    public function getRedirectMethod()
    {
        return 'GET';
    }
}
