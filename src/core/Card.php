<?php

namespace marcusvbda\zoop\core;


class Card extends Core
{
    public function find($token_id)
    {
        try {
            $route = $this->route . '/tokens/' . $token_id;
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
            $route = $this->route . '/cards/tokens';
            $request = $this->api->post($route, $this->makeRequestData($data));
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }
}
