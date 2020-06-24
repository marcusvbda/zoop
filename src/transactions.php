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

    public function get()
    {
        try {
            $_self = self::make();
            $route = $_self->route . '/sellers/' . $this->seller_id . '/transactions';
            $request = $_self->api->get($route);
            $response = json_decode($request->getBody()->getContents(), true);
            return $_self->client->returnResponse($response);
        } catch (\Exception $e) {
            return $_self->client->responseException($e);
        }
    }

    public function create($data)
    {
        $data["currency"] = config("zoop.currency");
        $data["type"] = @$data["card"] ? "card" : "bankslip";
        $data["usage"] = "single_use"; //ou reusable
        $_data["source"] = $data;
        $_data["amount"] = $data["amount"];
        $_data["currency"] = $data["currency"];
        $_data["description"] = "Venda";
        $_data["on_behalf_of"] = $this->seller_id;
        $_data["payment_type"] = $data["type"] == "card" ? "credit" : "bankslip";
        try {
            $_self = self::make();
            $route = $_self->route . '/transactions';
            $request = $_self->api->post($route, [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode($_data)
            ]);
            $response = json_decode($request->getBody()->getContents(), true);
            return $_self->client->returnResponse($response);
        } catch (\Exception $e) {
            return $_self->client->responseException($e);
        }
    }
}
