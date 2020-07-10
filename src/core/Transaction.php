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
        try {
            $route = $this->route . '/transactions';
            $request = $this->api->post($route, $this->makeRequestData($data));
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function chargeback($transaction_id, $data = [])
    {
        try {
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
            $route = $this->route . '/transactions/' . $transaction_id . '/split_rules/' . $id;
            $request = $this->api->delete($route);
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }
}
