<?php

namespace Flooris\ShopwareApiIntegration\Models;

use stdClass;

class CustomerModel extends AbstractModel
{
    public string $id;
    public string $firstName;
    public string $lastName;
    public string $email;
    public array $phoneNumbers;
    public array $addresses;

    public function handleResponse(stdClass $response): void
    {
        $this->id        = $response->id;
        $this->firstName = $response->firstName;
        $this->lastName  = $response->lastName;
        $this->email     = $response->email;
        $this->addresses = $response->addresses;
        
        foreach ($response->addresses as $address) {
            if ($address->phoneNumber) {
                $this->phoneNumbers[] = [
                    "phoneNumber" => $address->phoneNumber,
                    "addressId"   => $address->id,
                ];
            }
        }
    }
}
