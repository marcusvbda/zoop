<?php

namespace marcusvbda\zoop\core;


class Seller extends Core
{
    public function create($data)
    {
        try {
            if (@$data["taxpayer_id"]) { //pessoa física
                $data["taxpayer_id"] = Helpers::sanitizeString($data["taxpayer_id"]);
                $route = $this->route . '/sellers/individuals';
            } else { //pessoa jurídica
                if (@$data["ein"]) $data["ein"] = Helpers::sanitizeString($data["ein"]);
                if (@$data["owner"]["taxpayer_id"]) {
                    $data["owner"]["taxpayer_id"] = Helpers::sanitizeString($data["owner"]["taxpayer_id"]);
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
            $seller = $this->find($id);
            $route = $this->route . '/sellers/' . (($seller->type == "business") ? 'businesses/' : 'individuals/') . $id;
            $request = $this->api->put($route, $this->makeRequestData($data));
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }
}
