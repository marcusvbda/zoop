<?php

namespace marcusvbda\zoop;

use GuzzleHttp\Client as  gClient;

class Client
{

    public $configuration = [];

    public function __construct()
    {
        $this->makeConfiguration();
    }

    private function makeConfiguration($seller_id = null)
    {
        $env = config("zoop.env");
        $config = config("zoop")[$env];
        $this->configuration = [
            'api_version' => config("zoop.version"),
            'marketplace' => @$config["marketplace_id"],
            'gateway' => 'zoop',
            'base_url' => $config["endpoint"],
            'auth' => [
                'on_behalf_of' => $seller_id,
                'token' => (@$config["zpk"] ? @$config["zpk"] : "")
            ],
            'guzzle' =>  new gClient([
                'base_uri' => $config["endpoint"],
                'timeout' => 10,
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode((@$config["zpk"] ? @$config["zpk"] : '') . ':')
                ]
            ])
        ];
    }

    public function responseException($e)
    {
        if (!in_array('getResponse', \get_class_methods($e))) {
            throw new \Exception($e->getMessage(), 1);
        }
        throw new \Exception(\json_encode(\json_decode($e->getResponse()->getBody()->getContents(), true)), 1);
    }
}
