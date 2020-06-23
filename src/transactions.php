<?php

namespace marcusvbda\zoop;

class Transactions
{
    protected $seller_id = null;

    public function __construct($seller_id)
    {
        $this->seller_id = $seller_id;
    }

    public static function make()
    {
        $client = new Client();
        $api = $client->configuration['guzzle'];
        $route = $client->configuration["api_version"] . '/marketplaces/' . $client->configuration['marketplace'];
        return (object) ["client" => $client, "api" => $api, "route" => $route];
    }

    public static function seller($id)
    {
        return new Transactions($id);
    }

    public static function _get($seller_id)
    {
        try {
            $_self = self::make();
            $route = $_self->route . '/sellers/' . $seller_id . '/transactions';
            $request = $_self->api->get($route);
            $response = json_decode($request->getBody()->getContents(), true);
            return $_self->client->returnResponse($response);
        } catch (\Exception $e) {
            return $_self->client->responseException($e);
        }
    }

    public function get()
    {
        return self::_get($this->seller_id);
    }
}
