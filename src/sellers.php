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

    public function get($id = null)
    {
        try {
            $route = $this->route . '/sellers';
            if ($id) $route .= "/" . $id;
            $request = $this->api->request('GET', $route);
            $response = json_decode($request->getBody()->getContents(), true);
            if ($response && is_array($response)) {
                return $response;
            }
            return false;
        } catch (\Exception $e) {
            return $this->client->responseException($e);
        }
    }

    public function find($id)
    {
        return $this->get($id);
    }
}
