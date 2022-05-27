<?php

namespace Omnipay\CryptoCloud;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    protected $gateway;

    private $options;

    public function setUp(): void
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(),$this->getHttpRequest());

        $this->options = [
            "shop_id" => "DxIkunYHxbqT0Rz4",
            "amount" => '102.11', // USD only
            "order_id" => '123',
            "email" => "hsd@mail.com",
            "currency" => "RUB",
        ];
    }

    public function testRequestBody()
    {
        $data = $this->options;

        $data['data'] = (object) $this->options;

        $this->gateway->setApiKey("1234");

        $request = $this->gateway->createInvoice($this->options);

        $this->assertEquals($data,$request->getData());

    }

    public function testSuccessSendRequest(){

        $this->setMockHttpResponse('invoiceCreateResponse.txt');

        $this->gateway->setApiKey("1234");

        $request = $this->gateway->createInvoice($this->options);

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals("DZLF42",$response->getInvoiceId());
        $this->assertEquals("https://cryptocloud.plus/pay/DZLF42",$response->getInvoiceLink());
    }

    public function testSuccessResponseData()
    {
        $expectedData = [
            'result' => 'success',
            'pay_url' => 'https://cryptocloud.plus/pay/DZLF42',
            'currency' => 'BTC',
            'invoice_id' => 'DZLF42',
        ];

        $this->setMockHttpResponse('invoiceCreateResponse.txt');

        $this->gateway->setApiKey("1234");

        $request = $this->gateway->createInvoice($this->options);

        $response = $request->send();

        $this->assertEquals($expectedData,$response->getMessage());
    }

    private function prepareTestSignWithApiKey() {
        return hash_hmac(
            'sha256',
            "RUB5000Company namebuy something special",
            "1234"
        );
    }

}