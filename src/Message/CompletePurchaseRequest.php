<?php
/**
 * CryptoCloud driver for Omnipay PHP payment library
 *
 * @link      https://github.com/getviewerspro/omnipay-cryptocloud
 * @package   omnipay-cryptocloud
 * @license   MIT
 * @copyright Copyright (c) 2022, getViewersPRO (https://getviewers.pro/)
 */

namespace Omnipay\CryptoCloud\Message;

/**
 * Enot Complete Purchase Request.
 */
class CompletePurchaseRequest extends AbstractRequest
{
    /**
     * Get the data for this request.
     * @return array request data
     */
    public function getData()
    {
        $this->validate('sign_2');

        return $this->httpRequest->request->all();
    }

    /**
     * Send the request with specified data.
     * @param mixed $data The data to send
     * @return CompletePurchaseResponse
     */
    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }
}
