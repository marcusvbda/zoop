<?php

namespace marcusvbda\zoop\core;

class Seller extends Core
{
    public function create($data)
    {
        try {
            $this->setVersion("v1");
            if (@$data["taxpayer_id"]) { //pessoa física
                $data["taxpayer_id"] = $data["taxpayer_id"];
                $route = $this->route . '/sellers/individuals';
            } else { //pessoa jurídica
                if (@$data["ein"]) $data["ein"] = $data["ein"];
                if (@$data["owner"]["taxpayer_id"]) {
                    $data["owner"]["taxpayer_id"] = $data["owner"]["taxpayer_id"];
                }
                $route = $this->route . '/sellers/businesses';
            }
            $request = $this->api->post($route, $this->makeRequestData($data));
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function get($params = [])
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

    public function find($id)
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

    public function delete($id)
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

    public function update($id, $data = [])
    {
        try {
            $this->setVersion("v1");
            $seller = $this->find($id);
            $route = $this->route . '/sellers/' . (($seller->type == "business") ? 'businesses/' : 'individuals/') . $id;
            $request = $this->api->put($route, $this->makeRequestData($data));
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function getBalance($seller_id, $params = [])
    {
        try {
            $this->setVersion("v1");
            $route = $this->route . '/sellers/' . $seller_id . '?' . http_build_query($params);
            $request = $this->api->get($route);
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }
}
