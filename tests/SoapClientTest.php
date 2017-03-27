<?php

namespace Tests\EasySoapClient;

use EasySoapClient\Client;
use EasySoapClient\Context\StreamContext;
use EasySoapClient\Options\Options;
use EasySoapClient\AuthOptions;
use EasySoapClient\Configuration;
use EasySoapClient\ProxyOptions;
use PHPUnit\Framework\TestCase;

class SoapClientTest extends TestCase
{

    /**
     * @var Configuration
     */
    protected $config;

    protected function setUp()
    {
        $this->config = new Configuration(
            'http://www.webservicex.net/ConvertTemperature.asmx?WSDL'
        );
    }

    public function testSoapClientConfigurationInstance()
    {
        $this->assertInstanceOf('EasySoapClient\Configuration', $this->config);
    }

    public function testSoapClientInstance()
    {
        $client = (new Client($this->config))->consume();
        $this->assertInstanceOf('SoapClient', $client);
    }

    public function testSoapClientOptionsInstance()
    {
        $proxy = (new ProxyOptions('localhost', 80, 'easy-soapclient', '123'))->getProxy();
        $auth = (new AuthOptions('easy-soapclient', 1))->getAuth();
        $options = (new Options($proxy, $auth));

        $this->assertInstanceOf('EasySoapClient\Options\Options', $options);
    }

    public function testSoapClientOptionsType()
    {
        $proxy = (new ProxyOptions('localhost', 80, 'easy-soapclient', '123'))->getProxy();
        $auth = (new AuthOptions('easy-soapclient', 1))->getAuth();
        $options = (new Options($proxy, $auth))->get();
        $this->assertInternalType('array', $options);
    }

    public function testSoapClientProxyType()
    {
        $proxy = (new ProxyOptions('localhost', 80, 'easy-soapclient', '123'))->getProxy();
        $this->assertInternalType('array', $proxy);
    }

    public function testSoapClientAuthType()
    {
        $auth = (new AuthOptions('easy-soapclient', 1))->getAuth();
        $this->assertInternalType('array', $auth);
    }

    public function testSoapClientStreamContextIsNotEmpty()
    {
        $context = (new StreamContext())->get();
        $this->assertNotEmpty($context);
    }

    public function testSoapClientOptionsIsNotEmpty()
    {
        $options = (new Options([], []))->get();
        $this->assertNotEmpty($options);
    }

    public function testSoapClientResult()
    {
        $consume = (new Client($this->config))->consume();
        $this->assertNotEmpty($consume);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Url is empty
     */
    public function testSoapClientUrlConfigurationException()
    {
        $config = new Configuration(
            ''
        );

        (new Client($config));
    }

}
