<?php

namespace marcusvbda\zoop\core;

class Seller extends Core
{
    protected $seller_id = null;
    protected $plan_id = null;
    protected $transaction_id = null;
    protected $document_category_name = null;

    public function __construct($id = null)
    {
        parent::__construct();
        $this->seller_id = $id;
    }

    public static function sellerId($id)
    {
        return new Seller($id);
    }

    public function transactionId($id)
    {
        $this->transaction_id = $id;
        return $this;
    }

    public function planId($id)
    {
        $this->plan_id = $id;
        return $this;
    }

    public function documentCategoryName($name)
    {
        $this->document_category_name = $name;
        return $this;
    }

    public static function get($params = [])
    {
        $params = Helpers::makeGetParams($params);
        $ob = new Seller();
        return $ob->_get($params);
    }

    public static function balance($id, $params = [])
    {
        $params = Helpers::makeGetParams($params);
        $ob = new Seller();
        return $ob->_balance($id, $params);
    }

    public static function create($data = [])
    {
        if (@$data["taxpayer_id"]) $data["taxpayer_id"] = Helpers::sanitizeString($data["taxpayer_id"]);
        if (@$data["ein"]) $data["ein"] = Helpers::sanitizeString($data["ein"]);
        $ob = new Seller();
        if (Helpers::isIndividual(@$data)) return $ob->_create("individuals", $data);
        return $ob->_create("businesses", $data);
    }

    public static function find($id)
    {
        $ob = new Seller();
        return $ob->_find($id);
    }

    public static function delete($id)
    {
        $ob = new Seller();
        return $ob->_delete($id);
    }

    public function _create($type, $data)
    {
        try {
            $this->setVersion("v1");
            $route = $this->route . '/sellers/' . $type;
            $request = $this->api->post($route, $this->makeRequestData($data));
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function _get($params = [])
    {
        try {
            $this->setVersion("v1");
            $route = $this->route . '/sellers?' . http_build_query($params);
            $request = $this->api->get($route);
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function _find($id)
    {
        try {
            $this->setVersion("v1");
            $route = $this->route . '/sellers/' . $id;
            $request = $this->api->get($route);
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function _delete($id)
    {
        try {
            $this->setVersion("v1");
            $route = $this->route . '/sellers/' . $id;
            $request = $this->api->delete($route);
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function update($data = [])
    {
        try {
            $this->setVersion("v1");
            $seller = $this->find($this->seller_id);
            $route = $this->route . '/sellers/' . (($seller->type == "business") ? 'businesses/' : 'individuals/') . $this->seller_id;
            $request = $this->api->put($route, $this->makeRequestData($data));
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function _balance($seller_id, $params = [])
    {
        try {
            $this->setVersion("v1");
            $route = $this->route . '/sellers/' . $seller_id . '/balances/history?' . http_build_query($params);
            $request = $this->api->get($route);
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function getTransaction($params = [])
    {
        $trans = new Transaction($this->seller_id);
        $params = Helpers::makeGetParams($params);
        return $trans->get($params);
    }

    public function findTransaction($transaction_id)
    {
        $trans = new Transaction($this->seller_id);
        return $trans->find($transaction_id);
    }

    public function createTransaction($data = [])
    {
        $trans = new Transaction($this->seller_id);
        $data["currency"] =  $this->complete_env["currency"];
        $data["on_behalf_of"] =  $this->seller_id;
        return $trans->create($this->seller_id, $data);
    }

    public function changebackTransaction($amount)
    {
        $transaction = new Transaction();
        return $transaction->chargeback($this->transaction_id, [
            "on_behalf_of" => $this->seller_id,
            "amount" => $amount
        ]);
    }

    public function createDocument($file = "")
    {
        $docs = new SellerDocuments($this->seller_id);
        return $docs->create([
            "file" => $file,
            "category" => $this->document_category_name
        ]);
    }

    public function createSubscription($data = [])
    {
        $sub = new Subscriptions();
        $data["plan"] = $this->plan_id;
        $data["customer"] = $this->seller_id;
        $data["currency"] =  $this->complete_env["currency"];
        $data["on_behalf_of"] =  $this->seller_id;
        return $sub->create($data);
    }
}
