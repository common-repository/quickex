<?php

class QuickexApi
{
    private $host = 'https://quickex.io/v1/api/';
    private $apiKey = '';

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getRate($params)
    {
        return $this->httpRequest('rate', $params);
    }

    public function getRateInterval($params)
    {
        return $this->httpRequest('rate-interval', $params);
    }

    public function validateAddress($params)
    {
        return $this->httpRequest('validate-address', $params);
    }

    public function exchangeCreate($params)
    {
        return $this->httpRequest('exchange-create', $params, true);
    }

    public function getPairs()
    {
        $cacheKey = 'q-pairs';
        $pairs    = wp_cache_get($cacheKey);
        if (!$pairs) {
            $pairs = $this->httpRequest('pairs');
            wp_cache_set($cacheKey, $pairs, '', 3600);
        }

        return $pairs;
    }

    public function getСurrencies($array = false)
    {
        $cacheKey   = 'q-currencies';
        $сurrencies = wp_cache_get($cacheKey);
        if (!$сurrencies) {
            $сurrencies = $this->httpRequest('currencies');
            wp_cache_set($cacheKey, $сurrencies, '', 3600);
        }

        return $array ? json_decode($сurrencies, true) : $сurrencies;
    }

    public function getСurrencyInfo($name)
    {
        $сurrencies = json_decode($this->getСurrencies(), true);

        return isset($сurrencies[$name]) ? $сurrencies[$name] : null;
    }

    public function exchangeStatus($params)
    {
        $data = $this->httpRequest('exchange-status', $params, true);
        $data['statusName'] = $this->getStatusName($data['status']);
        $data['progress'] = $this->getProgress($data['status']);
        return $data;
    }

    private static $status = [
        'waiting_deposit'  => 'Waiting',
        'deposit_received' => 'Exchanging',
        'exchanging'       => 'Exchanging',
        'sending'          => 'Sending',
        'success'          => 'Success',
        'time_expired'     => 'Time expired',
        'failed'           => 'Failed',
    ];

    public function getStatusName($status)
    {
        return isset(self::$status[$status]) ? self::$status[$status] : '';
    }

    private static $progress = [
        'waiting_deposit'  => '0',
        'deposit_received' => '20',
        'exchanging'       => '45',
        'sending'          => '80',
        'success'          => '100',
        'time_expired'     => '0',
        'failed'           => '0',
    ];

    public function getProgress($status)
    {
        return isset(self::$progress[$status]) ? self::$progress[$status] : '';
    }

    private function httpRequest($url, $params = [], $array = false)
    {
        $params['key'] = $this->apiKey;
        $query         = http_build_query($params, '', '&');
        $url           = $this->host . $url . '?' . $query;

        $body = wp_remote_get($url);
        $body = isset($body['body']) ? $body['body'] : $body;
        if ($array) {
            $body = json_decode($body, true);
        }

        return $body;
    }

    public function getRates()
    {
        $cacheKey   = 'rates';
        $rates = wp_cache_get($cacheKey);
        if (!$rates) {
            $rates = $this->httpRequest('rates');
            wp_cache_set($cacheKey, $rates, '', 60);
        }

        return json_decode($rates, true);
    }

}