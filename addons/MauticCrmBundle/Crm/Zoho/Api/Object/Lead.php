<?php
namespace MauticAddon\MauticCrmBundle\Crm\Zoho\Api\Object;

use MauticAddon\MauticCrmBundle\Api\CrmApi;

class Lead extends CrmApi
{
    /**
     * List types
     *
     * @return mixed
     */
    public function getFields($module)
    {
        $tokenData = $this->auth->getAccessTokenData();

        $request_url = sprintf('%s%s/getFields',$tokenData['endpoint_url'],$module);
        $parameters = array(
            'authtoken' => $tokenData['authtoken'],
            'scope' => 'crmapi'
        );

        $response = $this->auth->makeRequest($request_url, $parameters);

        return $response;
    }

    /**
     * @param $module
     * @param $data
     * @return array
     */
    public function create($module, $data)
    {
        //https://crm.zoho.com/crm/private/xml/Leads/insertRecords
        $tokenData = $this->auth->getAccessTokenData();

        $request_url = sprintf('%s%s/InsertRecords',$tokenData['endpoint_url'],$module);
        $parameters = array(
            'authtoken' => $tokenData['authtoken'],
            'scope' => 'crmapi',
            'xmlData' => $data,
            'duplicateCheck' => 2 //update if exists
        );

        $response = $this->auth->makeRequest($request_url, $parameters);

        return $response;
    }
}