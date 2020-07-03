<?php

namespace marcusvbda\zoop\core;


class SellerDocuments extends Core
{
    private $seller_id = null;

    public function __construct($seller_id)
    {
        parent::__construct();
        $this->seller_id = $seller_id;
    }

    public function get($params = [])
    {
        try {
            $route = $this->route . '/sellers/' . $this->seller_id . '/documents?' . http_build_query($params);
            $request = $this->api->get($route);
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function create($data = [])
    {
        try {
            $route = $this->route . '/sellers/' . $this->seller_id . '/documents';
            $request = $this->requestWithCURL("file", $route, $this->makeRequestData($data, 'FILE'));
            $response = (object) json_decode($request[0], true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function update($id, $data = [])
    {
        try {
            $route = $this->route . '/sellers/documents/' . $id;
            $request = $this->api->put($route, $this->makeRequestData($data));
            $response = (object) json_decode($request->getBody()->getContents(), true);
            return $this->returnResponse($response);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }
}
