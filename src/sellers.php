<?php

namespace marcusvbda\zoop;

class Sellers
{
    protected $client = null;
    protected $api = null;
    protected $route = null;

    public function __construct()
    {
        $this->client = new Client();
        $this->api = $this->client->configuration['guzzle'];
        $this->route = $this->client->configuration["api_version"] . '/marketplaces/' . $this->client->configuration['marketplace'];
    }

    public function get()
    {
        try {
            $route = $this->route . '/sellers';
            $request = $this->api->get($route);
            $response = json_decode($request->getBody()->getContents(), true);
            return $this->client->returnResponse($response);
        } catch (\Exception $e) {
            return $this->client->responseException($e);
        }
    }

    public function find($id)
    {
        try {
            $route = $this->route . '/sellers/' . $id;
            $request = $this->api->get($route);
            $response = json_decode($request->getBody()->getContents(), true);
            return $this->client->returnResponse($response);
        } catch (\Exception $e) {
            return $this->client->responseException($e);
        }
    }

    public function createIndividual($data)
    {
        try {
            $route = $this->route . '/sellers/individuals';
            $request = $this->api->post($route, [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode($data)
            ]);
            $response = json_decode($request->getBody()->getContents(), true);
            return $this->client->returnResponse($response);
        } catch (\Exception $e) {
            return $this->client->responseException($e);
        }
    }

    public function update($id, $data = [])
    {
        try {
            $route = $this->route . '/sellers/individuals/' . $id;
            $request = $this->api->put($route, [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode($data)
            ]);
            $response = json_decode($request->getBody()->getContents(), true);
            return $this->client->returnResponse($response);
        } catch (\Exception $e) {
            return $this->client->responseException($e);
        }
    }

    public function delete($id)
    {
        try {
            $route = $this->route . '/sellers/' . $id;
            $request = $this->api->delete($route);
            $response = json_decode($request->getBody()->getContents(), true);
            return $this->client->returnResponse($response);
        } catch (\Exception $e) {
            return $this->client->responseException($e);
        }
    }
}
