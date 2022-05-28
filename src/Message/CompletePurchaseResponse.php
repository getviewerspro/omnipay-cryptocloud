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

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * Enot Complete Purchase Response.
 */
class CompletePurchaseResponse extends AbstractResponse
{
    /**
     * @var CompletePurchaseRequest|RequestInterface
     */
    protected $request;
    protected $merchantIp = '193.232.179.110';

    public function __construct(RequestInterface $request, $data)
    {
        info($request, $data);

        $this->request = $request;
        $this->data    = $data;

        if ($this->request->header('x-forwarded-for') !== $this->merchantIp) {
            throw new InvalidResponseException('Invalid ip');
        }
    }

    public function send()
    {
        return $this;
    }

    public function isSuccessful()
    {
        return true;
    }

    public function getTransactionId()
    {
        return $this->data['order_id'];
    }

    public function getTransactionReference()
    {
        return $this->data['invoice_id'];
    }

    public function getAmount()
    {
        return (string)$this->data['amount_crypto'];
    }

    public function getCurrency()
    {
        return (string)$this->data['currency'];
    }

    public function getMoney()
    {
        return (string)$this->data['amount_USD'].' USD';
    }

    /**
     * @return string
     */
    protected function getPaymentSystem()
    {
        $map = [
            'BTC'    => 'Bitcoin',
            'ETH'    => 'Ethereum',
            'LTC'    => 'Litecoin',
            'USDT'   => 'USDT-ERC-20',
        ];

        return isset($map[$this->data['currency']])
            ? $map[$this->data['currency']]
            : $this->data['currency'];
    }
}
