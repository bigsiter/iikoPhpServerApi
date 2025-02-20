<?php


namespace IikoServer\Api;


use IikoServer\Api\Methods\Departments;
use IikoServer\Api\Methods\Invoices;
use IikoServer\Api\Methods\Persons;
use IikoServer\Api\Methods\Products;
use IikoServer\Api\Methods\Stores;
use IikoServer\Api\Methods\Suppliers;
use IikoServer\Api\Methods\OlapV2;

class IikoClient extends IikoServerApi implements IikoConnections
{


    use Stores,
        Suppliers,
        IikoRequests,
        OlapV2,
        Departments,
        Products,
        Persons,
        Invoices {
        Stores::request insteadof Suppliers;
        Suppliers::request insteadof Stores;
        Departments::request insteadof IikoRequests;
        Products::request insteadof Departments;
        Persons::request insteadof Products;
        Invoices::request insteadof Persons;
    }

    /**
     * IikoClient constructor.
     * @param string $login
     * @param string $password
     * @param string $serverUrl
     */
    public function __construct(string $login = null, string $password = null, string $serverUrl = null)
    {
        parent::__construct($login, $password, $serverUrl);
    }


    public function close()
    {

        $close = curl_init($this->serverUrl."/resto/api/logout?key=".$this->key."");
        curl_setopt($close, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($close, CURLOPT_HEADER, 0);
        curl_exec($close);
        curl_close($close);

    }
}
