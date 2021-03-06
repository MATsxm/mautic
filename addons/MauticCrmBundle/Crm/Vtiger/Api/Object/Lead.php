<?php
namespace MauticAddon\MauticCrmBundle\Crm\Vtiger\Api\Object;

use MauticAddon\MauticCrmBundle\Api\CrmApi;

class Lead extends CrmApi
{
    protected $object = "Leads";

    /**
     * List types
     *
     * @return mixed
     */
    public function listTypes()
    {
        $tokenData = $this->auth->getAccessTokenData();

        $request_url = sprintf('%s/webservice.php',$tokenData['vtiger_url']);
        $parameters = array(
            'operation' => 'listtypes',
            'sessionName' => $tokenData['session_id']
        );

        $response = $this->auth->makeRequest($request_url, $parameters);

        return $response['result'];
    }

    /**
     * List types
     *
     * @return mixed
     */
    public function describe($type)
    {
        $tokenData = $this->auth->getAccessTokenData();

        $request_url = sprintf('%s/webservice.php',$tokenData['vtiger_url']);
        $parameters = array(
            'operation' => 'describe',
            'sessionName' => $tokenData['session_id'],
            'elementType' => $type
        );

        $response = $this->auth->makeRequest($request_url, $parameters);

        return $response['result'];
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $tokenData = $this->auth->getAccessTokenData();

        $request_url = sprintf('%s/webservice.php',$tokenData['vtiger_url']);
        $parameters = array(
            'operation' => 'create',
            'sessionName' => $tokenData['session_id'],
            'elementType' => $this->object,
            'element' => json_encode($data)
        );

        $response = $this->auth->makeRequest($request_url, $parameters);

        return $response['result'];
    }
}