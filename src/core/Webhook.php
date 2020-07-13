<?php

namespace marcusvbda\zoop\core;


class Webhook extends Core
{
    public function create($data)
    {
        try {
            $this->setVersion("v1");
            $route = $this->route . '/webhooks';
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
            $route = $this->route . '/webhooks?' . http_build_query($params);
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
            $route = $this->route . '/webhooks/' . $id;
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
            $route = $this->route . '/webhooks/' . $id;
            $request = $this->api->delete($route);
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }
}
