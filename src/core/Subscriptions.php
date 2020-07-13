<?php

namespace marcusvbda\zoop\core;


class Subscriptions extends Core
{
    public function get($params = [])
    {
        try {
            $this->setVersion("v1");
            $route = $this->route . '/subscriptions?' . http_build_query($params);
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
            $route = $this->route . '/subscriptions/' . $id;
            $request = $this->api->get($route);
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function create($data)
    {
        try {
            $this->setVersion("v1");
            $route = $this->route . '/subscriptions';
            $request = $this->api->post($route, $this->makeRequestData($data));
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
            $route = $this->route . '/subscriptions/' . $id;
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
            $route = $this->route . '/subscriptions/' . $id;
            $request = $this->api->put($route, $this->makeRequestData($data));
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function suspend($id)
    {
        try {
            $this->setVersion("v1");
            $route = $this->route . '/subscriptions/' . $id . '/suspend';
            $request = $this->api->post($route);
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function reactivate($id)
    {
        try {
            $this->setVersion("v1");
            $route = $this->route . '/subscriptions/' . $id . '/activate';
            $request = $this->api->post($route);
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }
}
