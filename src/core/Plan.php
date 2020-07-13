<?php

namespace marcusvbda\zoop\core;


class Plan extends Core
{

    public static function create($data)
    {
        $ob = new Plan();
        $data["payment_methods"] = ["credit"];
        return $ob->_create($data);
    }

    public function _get($params = [])
    {
        try {
            $this->setVersion("v2");
            $route = $this->route . '/plans?' . http_build_query($params);
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
            $this->setVersion("v2");
            $route = $this->route . '/plans/' . $id;
            $request = $this->api->get($route);
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }


    public function _create($data = [])
    {
        try {
            $this->setVersion("v2");
            $route = $this->route . '/plans';
            $request = $this->api->post($route, $this->makeRequestData($data));
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e, true);
        }
    }

    public static function get($params = [])
    {
        $params = Helpers::makeGetParams($params);
        $ob = new Plan();
        return $ob->_get($params);
    }

    public static function find($id)
    {
        $ob = new Plan();
        return $ob->_find($id);
    }

    public static function delete($id)
    {
        $ob = new Plan();
        return $ob->_delete($id);
    }

    public function _delete($id)
    {
        try {
            $this->setVersion("v2");
            $route = $this->route . '/plans/' . $id;
            $request = $this->api->delete($route);
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e, true);
        }
    }
}
