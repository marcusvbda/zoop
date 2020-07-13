<?php

namespace marcusvbda\zoop\core;

use Error;
use Exception;
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
    }

    public function setVersion($version)
    {
        $this->api_version = $version;
        $this->route = $this->env_config["endpoint"] . "/" . $this->api_version . "/marketplaces/" . $this->env_config["marketplace_id"];
        $this->configuration["api_version"] = $version;
    }

    private function makeRoute()
    {
        $this->route = $this->env_config["endpoint"] . "/" . $this->api_version . "/marketplaces/" . $this->env_config["marketplace_id"];
    }

    private function makeConfiguration()
    {
        $this->configuration["api_version"] = $this->api_version;
        $this->configuration["marketplace"] = @$this->env_config["marketplace_id"];
        $this->configuration["gateway"] = 'zoop';
        $this->configuration["base_url"] = $this->env_config["endpoint"];
        $this->configuration["auth"] = [
            'token' => $this->getZPK()
        ];
    }

    private function getAuthorization()
    {
        $token  = base64_encode($this->getZPK() . ':');
        return "Basic $token";
    }

    private function makeApi()
    {

        $this->api = new gClient([
            'base_uri' => $this->env_config["endpoint"],
            'timeout' => 10,
            'headers' => [
                'Authorization' => $this->getAuthorization()
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

    public function makeRequestData($data = [], $content_type = 'GUZZLE')
    {
        if ($content_type == "FILE") {
            $extension = explode(".", $data["file"]);
            $extension = "." . $extension[1];
            $name =  uniqid() . $extension;
            $data["file"] = new \CURLFile($data["file"], '', $name);
            return $data;
        }
        return [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => json_encode($data)
        ];
    }

    private function getZPK()
    {
        return (@$this->env_config["zpk"] ? @$this->env_config["zpk"] : "");
    }

    public function requestWithCURL($method, $url, $data = [])
    {
        $headers = [
            'Authorization' => $this->getAuthorization()
        ];
        $curl = curl_init();
        $opts = array();

        if (strtolower($method) == 'file') {
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $data;
        }

        $opts[CURLOPT_URL] = $url;
        $opts[CURLOPT_USERPWD] = $this->getZPK();
        $opts[CURLOPT_RETURNTRANSFER] = true;
        $opts[CURLOPT_CONNECTTIMEOUT] = 30;
        $opts[CURLOPT_TIMEOUT] = 80;
        $opts[CURLOPT_HTTPHEADER] = $headers;

        $opts[CURLOPT_SSL_VERIFYHOST] = 2;
        $opts[CURLOPT_SSL_VERIFYPEER] = false;

        curl_setopt_array($curl, $opts);

        $response_body = curl_exec($curl);
        $response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        return array($response_body, $response_code);
    }
}
