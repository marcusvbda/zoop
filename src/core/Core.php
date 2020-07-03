<?php

namespace marcusvbda\zoop\core;

use Error;
use GuzzleHttp\Client as  gClient;

class Core
{
    public $route = "";
    public $api_version = "v1";
    public $api = null;
    public $env_config = [];
    public $configuration = [];

    public function __construct()
    {
        $this->makeEnvConfig();
        $this->makeConfiguration();
        $this->makeRoute();
        $this->makeApi();
    }

    private function makeEnvConfig()
    {
        $env = config("zoop.env");
        $this->env_config = config("zoop")[$env];
        $this->api_version = config("zoop")["version"];
    }

    private function makeRoute()
    {
        $this->route = $this->env_config["endpoint"] . "/" . $this->api_version . "/marketplaces/" . $this->env_config["marketplace_id"];
    }

    private function makeConfiguration()
    {
        $this->configuration = [
            'api_version' => $this->api_version,
            'marketplace' => @$this->env_config["marketplace_id"],
            'gateway' => 'zoop',
            'base_url' => $this->env_config["endpoint"],
            'auth' => [
                'token' => (@$this->env_config["zpk"] ? @$this->env_config["zpk"] : "")
            ],
        ];
    }

    private function makeApi()
    {
        $token  = base64_encode((@$this->env_config["zpk"] ? @$this->env_config["zpk"] : '') . ':');
        $this->api = new gClient([
            'base_uri' => $this->env_config["endpoint"],
            'timeout' => 10,
            'headers' => [
                'Authorization' => "Basic $token"
            ]
        ]);
    }

    public function responseException($error, $isException = true)
    {
        if ($isException) {
            $error = @json_decode($error->getResponse()->getBody()->getContents())->error;
        }
        return Errors::get(@$error);
    }

    public function returnResponse($response)
    {
        if (@$response->error) return $this->responseException((object) $response->error, false);
        if ($response && is_array($response)) {
            return $response;
        }
        return $response;
    }

    public function makeRequestData($data = [])
    {
        return [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => json_encode($data)
        ];
    }
}
