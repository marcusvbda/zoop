<?php

namespace marcusvbda\zoop\core;


class Transaction extends Core
{
    private $seller_id = null;

    public function __construct($seller_id)
    {
        parent::__construct();
        $this->seller_id = $seller_id;
    }

    public function get($params = [])
    {
        try {
            $route = $this->route . '/sellers/' . $this->seller_id . '/transactions?' . http_build_query($params);
            $request = $this->api->get($route);
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function find($id)
    {
        try {
            $route = $this->route . '/transactions/' . $id;
            $request = $this->api->get($route);
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function create($data = [])
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
            $route = $this->route . '/transactions';
            $request = $this->api->post($route, $this->makeRequestData($_data));
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }
}
