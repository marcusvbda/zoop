<?php

namespace marcusvbda\zoop\core;


class Card extends Core
{
    public function find($id)
    {
        try {
            $this->setVersion("v1");
            $route = $this->route . '/tokens/' . $id;
            $request = $this->api->get($route);
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function createToken($data = [])
    {
        try {
            $this->setVersion("v1");
            $route = $this->route . '/cards/tokens';
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
            $route = $this->route . '/cards/' . $id;
            $request = $this->api->delete($route);
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function associateToBuyer($data)
    {
        try {
            $this->setVersion("v1");
            $route = $this->route . '/cards';
            $request = $this->api->post($route, $this->makeRequestData($data));
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }
}
