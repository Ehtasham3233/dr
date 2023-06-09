<?php

namespace App\Helpers;
use Exception;
class RequestError extends Exception
{
    private $responseCode;

    public function __construct($errorCode)
    {
        $this->responseCode = $errorCode;
//        если надо получать файл и строку в которой получена ошибка
//        $message = "Error in {$this->getFile()}, line: {$this->getLine()}: {$this->errorCodes[$errorCode]}";

        //$message = "{$this->errorCodes[$errorCode]}";
        //parent::__construct($message);
    }

    protected $errorCodes = array(
        'ACCESS_ACTIVATION' => 'Service successfully activated',
        'ACCESS_CANCEL'     => 'Activation canceled',
        'ACCESS_READY'      => 'Waiting for a new SMS',
        'ACCESS_RETRY_GET'  => 'Room readiness confirmed',
        'ACCOUNT_INACTIVE'  => 'No rooms available',
        'ALREADY_FINISH'    => 'The lease has already been completed',
        'ALREADY_CANCEL'    => 'The lease has already been canceled',
        'BAD_ACTION'        => 'Invalid action (action parameter)',
        'BAD_SERVICE'       => 'Incorrect service name (service parameter)',
        'BAD_KEY'           => 'Invalid API access key',
        'BAD_STATUS'        => 'Attempt to establish a non-existent status',
        'BANNED'            => 'account is blocked',
        'CANT_CANCEL'       => 'Unable to cancel the lease (more than 20 minutes have passed)',
        'ERROR_SQL'         => 'One of the parameters has an invalid value.',
        'NO_NUMBERS'        => 'There are no free numbers for receiving SMS from the current service',
        'NO_BALANCE'        => 'Out of balance',
        'NO_YULA_MAIL'      => 'You must have more than 500 rubles on your account to purchase services of the Mail.ru and Mamba holding',
        'NO_CONNECTION'     => 'No connection to servers sms-activate',
        'NO_ID_RENT'        => 'Rent id not specified',
        'NO_ACTIVATION'     => 'The specified activation id does not exist',
        'STATUS_CANCEL'     => 'Activation / rental canceled',
        'STATUS_FINISH'     => 'Rent paid and completed',
        'STATUS_WAIT_CODE'  => 'Waiting for the first SMS',
        'STATUS_WAIT_RETRY' => 'waiting for code clarification',
        'SQL_ERROR'         => 'One of the parameters has an invalid value.',
        'INVALID_PHONE'     => 'The room was not rented by you (wrong rental id)',
        'INCORECT_STATUS'   => 'Missing or incorrect status',
        'WRONG_SERVICE'     => 'Service does not support call forwarding',
        'WRONG_SECURITY'    => 'An error occurred when trying to transfer an activation ID without forwarding, or a completed / inactive activation'
    );

    public function getResponseCode()
    {
        return $this->errorCodes[$this->responseCode];
    }
}

class ErrorCodes extends RequestError
{
    public function checkExist($errorCode)
    {
        return array_key_exists($errorCode, $this->errorCodes);
    }
}

class SMSActivate
{
    private $url = 'https://api.sms-activate.org/stubs/handler_api.php';

    private $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getBalance()
    {
        return $this->request(array('api_key' => $this->apiKey, 'action' => __FUNCTION__), 'GET');
    }

    public function getBalanceAndCashBack()
    {
        return $this->request(array('api_key' => $this->apiKey, 'action' => __FUNCTION__), 'GET');
    }

    public function getTopCountriesByService($service = '', $freePrice = false)
    {
        $requestParam = array('api_key' => $this->apiKey, 'action' => __FUNCTION__, 'service' => $service, '$freePrice' => $freePrice);
        return $this->request($requestParam, 'POST', true);
    }

    public function getNumbersStatus($country = null, $operator = null)
    {
        $requestParam = array('api_key' => $this->apiKey, 'action' => __FUNCTION__);
        if ($country) {
            $requestParam['country'] = $country;
        }
        if ($operator && ($country == 0 || $country == 1 || $country == 2)) {
            $requestParam['service'] = $operator;
        }
        $response = array();
        $changeKeys = $this->request($requestParam, 'GET', true);
        foreach ($changeKeys as $services => $count) {
            $services = trim($services, "_01");
            $response[$services] = $count;
        }
        unset($changeKeys);
        return $response;
    }

    public function getNumber($service, $country = null, $forward = 0, $operator = null, $ref = null)
    {
        $requestParam = array('api_key' => $this->apiKey, 'action' => __FUNCTION__, 'service' => $service, 'forward' => $forward);
        if ($country) {
            $requestParam['country'] = $country;
        }
        if ($operator && ($country == 0 || $country == 1 || $country == 2)) {
            $requestParam['operator'] = $operator;
        }
        if ($ref) {
            $requestParam['ref'] = $ref;
        }
        return $this->request($requestParam, 'POST', null, 1);
    }

    public function getMultiServiceNumber($services, $forward = 0, $country = null, $operator = null, $ref = null)
    {
        $requestParam = array('api_key' => $this->apiKey, 'action' => __FUNCTION__, 'multiService' => $services, 'forward' => $forward);
        if ($country) {
            $requestParam['country'] = $country;
        }
        if ($operator && ($country == 0 || $country == 1 || $country == 2)) {
            $requestParam['operator'] = $operator;
        }
        if ($ref) {
            $requestParam['ref'] = $ref;
        }
        return $this->request($requestParam, 'POST', true, 1);
    }

    public function setStatus($id, $status, $forward = 0)
    {
        $requestParam = array('api_key' => $this->apiKey, 'action' => __FUNCTION__, 'id' => $id, 'status' => $status);

        if ($forward) {
            $requestParam['forward'] = $forward;
        }

        return $this->request($requestParam, 'POST', null, 3);
    }

    public function getStatus($id)
    {
        return $this->request(array('api_key' => $this->apiKey, 'action' => __FUNCTION__, 'id' => $id), 'GET', false, 2);
    }

    public function getCountries()
    {
        return $this->request(array('api_key' => $this->apiKey, 'action' => __FUNCTION__), 'GET', true);
    }

    public function getServices()
    {
        return $this->request(array('api_key' => $this->apiKey, 'action' => __FUNCTION__), 'GET', true);
    }


    

    public function getAdditionalService($service, $activationId)
    {
        return $this->request(array('api_key' => $this->apiKey, 'action' => __FUNCTION__, 'service' => $service, 'id' => $activationId), 'GET', false, 1);
    }

    public function getFullSms($id)
    {
        return $this->request(array('api_key' => $this->apiKey, 'action' => __FUNCTION__, 'id' => $id), 'GET');
    }

    public function getPrices($country = null, $service = null)
    {
        $requestParam = array('api_key' => $this->apiKey, 'action' => __FUNCTION__);

        if ($country !== null) {
            $requestParam['country'] = $country;
        }
        if ($service) {
            $requestParam['service'] = $service;
        }

        return $this->request($requestParam, 'GET', true);
    }

    public function getRentServicesAndCountries($time = 4, $operator = "any")
    {
        $requestParam = array('api_key' => $this->apiKey, 'action' => __FUNCTION__, 'rent_time' => $time, 'operator' => $operator);
        return $this->requestRent($requestParam, 'POST', true);
    }

    public function getRentNumber($service, $time = 4, $country = 0, $operator = "any", $url = '')
    {
        $requestParam = array('api_key' => $this->apiKey, 'action' => __FUNCTION__, 'service' => $service, 'rent_time' => $time, 'operator' => $operator, 'country' => $country, 'url' => $url);
        return $this->requestRent($requestParam, 'POST', true);
    }

    public function getRentStatus($id)
    {
        $requestParam = array('api_key' => $this->apiKey, 'action' => __FUNCTION__, 'id' => $id);
        return $this->requestRent($requestParam, 'POST', true);
    }

    public function setRentStatus($id, $status)
    {
        $requestParam = array('api_key' => $this->apiKey, 'action' => __FUNCTION__, 'id' => $id, 'status' => $status);
        return $this->requestRent($requestParam, 'POST', true);
    }

    public function getRentList()
    {
        $requestParam = array('api_key' => $this->apiKey, 'action' => __FUNCTION__);
        return $this->requestRent($requestParam, 'POST', true);
    }

    public function continueRentNumber($id, $time = 4)
    {
        $requestParam = array('api_key' => $this->apiKey, 'action' => __FUNCTION__, 'id' => $id, 'rent_time' => $time);
        return $this->requestRent($requestParam, 'POST', true);
    }

    public function getContinueRentPriceNumber($id, $time)
    {
        $requestParam = array('api_key' => $this->apiKey, 'action' => __FUNCTION__, 'id' => $id, 'rent_time' => $time);
        return $this->requestRent($requestParam, 'POST', false);
    }

    /**
     * @param $data
     * @param $method
     * @param null $parseAsJSON
     * @return mixed
     */
    private function request($data, $method, $parseAsJSON = null, $getNumber = null)
    {
        $method = strtoupper($method);

        if (!in_array($method, array('GET', 'POST'))) {
            throw new InvalidArgumentException('Method can only be GET or POST');
        }

        $serializedData = http_build_query($data);

        if ($method === 'GET') {
            $result = file_get_contents("$this->url?$serializedData");
        } else {
            $options = array(
                'http' => array(
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'POST',
                    'content' => $serializedData
                )
            );
            $context = stream_context_create($options);
            $result = file_get_contents($this->url, false, $context);
        }

        $responseError = new ErrorCodes($result);
        $check = $responseError->checkExist($result);

        try {
            if ($check) {
                throw new RequestError($result);
            }
        } catch (Exception $e) {
            return $e->getResponseCode();
        }

        if ($parseAsJSON) {
            return json_decode($result, true);
        }

        $parsedResponse = explode(':', $result);

        if ($getNumber == 1) {
            return array('id' => $parsedResponse[1], 'number' => $parsedResponse[2]);
        }
        if ($getNumber == 2) {
            return array('status' => $parsedResponse[0], 'code' => $parsedResponse[1]);
        }
        if ($getNumber == 3) {
            return array('status' => $parsedResponse[0]);
        }
        return $parsedResponse[1];
    }

    private function requestRent($data, $method, $parseAsJSON = null, $getNumber = null)
    {
        $method = strtoupper($method);

        if (!in_array($method, array('GET', 'POST'))) {
            throw new InvalidArgumentException('Method can only be GET or POST');
        }
        $serializedData = http_build_query($data);

        if ($method === 'GET') {
            $request_url = "$this->url?$serializedData";
            $result = file_get_contents($request_url);
        } else {
            $options = array(
                'http' => array(
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'POST',
                    'content' => $serializedData
                )
            );
            $context = stream_context_create($options);
            $result = file_get_contents($this->url, false, $context);
        }

        if ($parseAsJSON) {
            $result = json_decode($result, true);
//            $responsError = new ErrorCodes($result["message"]);
//            $check = $responsError->checkExist($result["message"]);  // раскоментить если необходимо включить исключения для Аренды
//            if ($check) {
//                throw new RequestError($result["message"]);
//            }
            return $result;
        }
        return $result;
    }
}


