<?php

namespace marcusvbda\zoop;

use marcusvbda\zoop\Transactions;

class Sellers
{
    public function __construct($data)
    {
        foreach ($data as $key => $value)  $this->$key = $value;
    }

    public static function createIndividual($data)
    {
        try {
            $_self = self::make();
            $route = $_self->route . '/sellers/individuals';
            $request = $_self->api->post($route, [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode($data)
            ]);
            $response = json_decode($request->getBody()->getContents(), true);
            return $_self->client->returnResponse($response);
        } catch (\Exception $e) {
            return $_self->client->responseException($e);
        }
    }

    public function transactions()
    {
        return new Transactions($this->id);
    }

    public function save()
    {
        return Sellers::update($this->id, (array) $this);
    }

    public function delete()
    {
        $result = Sellers::_delete($this->id);
        return $result["deleted"];
    }

    public static function make()
    {
        $client = new Client();
        $api = $client->configuration['guzzle'];
        $route = $client->configuration["api_version"] . '/marketplaces/' . $client->configuration['marketplace'];
        return (object) ["client" => $client, "api" => $api, "route" => $route];
    }

    public static function get()
    {
        try {
            $_self = self::make();
            $route = $_self->route . '/sellers';
            $request = $_self->api->get($route);
            $response = json_decode($request->getBody()->getContents(), true);
            return $_self->client->returnResponse($response);
        } catch (\Exception $e) {
            return $_self->client->responseException($e);
        }
    }

    public static function find($id)
    {
        try {
            $_self = self::make();
            $route = $_self->route . '/sellers/' . $id;
            $request = $_self->api->get($route);
            $response = json_decode($request->getBody()->getContents(), true);
            $result =  $_self->client->returnResponse($response);
            return new Sellers($result);
        } catch (\Exception $e) {
            return $_self->client->responseException($e);
        }
    }

    public static function update($id, $data = [])
    {
        try {
            $_self = self::make();
            $route = $_self->route . '/sellers/individuals/' . $id;
            $request = $_self->api->put($route, [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode($data)
            ]);
            $response = json_decode($request->getBody()->getContents(), true);
            $result =  $_self->client->returnResponse($response);
            return new Sellers($result);
        } catch (\Exception $e) {
            return $_self->client->responseException($e);
        }
    }

    public static function _delete($id)
    {
        try {
            $_self = self::make();
            $route = $_self->route . '/sellers/' . $id;
            $request = $_self->api->delete($route);
            $response = json_decode($request->getBody()->getContents(), true);
            return $_self->client->returnResponse($response);
        } catch (\Exception $e) {
            return $_self->client->responseException($e);
        }
    }
}
