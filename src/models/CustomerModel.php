<?php


namespace Flooris\FloorisShopwareApiIntegration\models;


class CustomerModel extends AbstractModel
{
    public string $id;
    public string $firstName;
    public string $lastName;
    public string $email;
    public string $phoneNumber;
    function handleResponse(): void
    {
        $response        = isset($this->response->data) ? $this->response->data : $this->response;
        $this->id        = $response->id;
        $this->firstName = $response->firstName;
        $this->lastName  = $response->lastName;
        $this->email     = $response->email;

        foreach($response->addresses as $address){
            if($address->phoneNumber){
                $this->phoneNumber = $address->phoneNumber;
                return;
            }
        }
    }
}
