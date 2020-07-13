<?php

namespace marcusvbda\zoop\core;


class Transaction extends Core
{
    private $seller_id = null;

    public function __construct($seller_id = null)
    {
        parent::__construct();
        $this->seller_id = $seller_id;
    }

    public function get($params = [])
    {
        try {
            $this->setVersion("v1");
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
            $this->setVersion("v1");
            $route = $this->route . '/transactions/' . $id;
            $request = $this->api->get($route);
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    private function createBuyer($data)
    {
        $buyer = new Buyer();
        $buyer = $buyer->create($data["buyer"]);
        unset($data["buyer"]);
        $data["customer"] = $buyer->id;
        return $data;
    }

    private function createTokenAndAssociateToBuyer($data)
    {
        $data = $this->createBuyer($data);
        if ($data["credit_card"]) {
            $card = new Card();
            $_card = $card->createToken($data["credit_card"]);
            $card->associateToBuyer([
                "token" => $_card->id,
                "customer" => $data["customer"],
            ]);
            $data["credit_card"] = $_card;
            unset($data["credit_card"]);
        }
        return $data;
    }

    private function createTransactionSplit($transaction, $data)
    {
        if (@$data["split"]) return $this->createSplitRule($transaction->id, $data["split"]);
    }

    public function create($seller_id = null, $data = [])
    {
        try {
            $this->setVersion("v1");
            $data["payment_type"] = "credit";
            if (@!$data["customer"]) $data = $this->createTokenAndAssociateToBuyer($data);
            $route = $this->route . '/transactions';
            $request = $this->api->post($route, $this->makeRequestData($data));
            $response = (object) json_decode($request->getBody()->getContents(), true);
            $response =  $this->returnResponse($response);
            $data = $this->createTransactionSplit($response, $data);
            return $response;
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function chargeback($transaction_id, $data = [])
    {
        try {
            $this->setVersion("v1");
            $route = $this->route . '/transactions/' . $transaction_id . '/void';
            $request = $this->api->post($route, $this->makeRequestData($data));
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function createSplitRule($transaction_id, $data = [])
    {
        try {
            $this->setVersion("v1");
            $route = $this->route . '/transactions/' . $transaction_id . '/split_rules';
            $request = $this->api->post($route, $this->makeRequestData($data));
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function getSplitRules($transaction_id, $id)
    {
        try {
            $this->setVersion("v1");
            $route = $this->route . '/transactions/' . $transaction_id . '/split_rules/' . $id;
            $request = $this->api->get($route);
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function deleteSplitRules($transaction_id, $id)
    {
        try {
            $this->setVersion("v1");
            $route = $this->route . '/transactions/' . $transaction_id . '/split_rules/' . $id;
            $request = $this->api->delete($route);
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }
}
