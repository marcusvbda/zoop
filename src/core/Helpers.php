<?php

namespace marcusvbda\zoop\core;

class Helpers
{
    public static function sanitizeString($str)
    {
        $str = preg_replace('/[áàãâä]/ui', 'a', $str);
        $str = preg_replace('/[éèêë]/ui', 'e', $str);
        $str = preg_replace('/[íìîï]/ui', 'i', $str);
        $str = preg_replace('/[óòõôö]/ui', 'o', $str);
        $str = preg_replace('/[úùûü]/ui', 'u', $str);
        $str = preg_replace('/[ç]/ui', 'c', $str);
        $str = preg_replace('/[^a-z0-9]/i', '', $str);
        $str = preg_replace('/_+/', '_', $str);
        return $str;
    }

    public static function makeGetParams($params)
    {
        $default = [
            "page" => 1,
            "limit" => 100,
            "sort" => "time-descending"
        ];
        foreach ($params as $key => $value)  $default[$key] = $value;
        return $default;
    }

    public static function isIndividual($data)
    {
        $doc_number = @$data["taxpayer_id"] ? $data["taxpayer_id"] : $data["ein"];
        $doc_number = static::sanitizeString($doc_number);
        return strlen($doc_number) == 11;
    }
}
