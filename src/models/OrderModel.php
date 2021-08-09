<?php


namespace Flooris\FloorisShopwareApiIntegration\models;


use stdClass;

class OrderModel extends AbstractModel
{
    public string $id;
    public stdClass $customer;
    public int $orderNumber;
    public string $saleChannel;
    public stdClass $billingAddress;
    public array $deliveries;
    public array $orderValue;
    public array $orderLineItems;
    public $createdAt;
    public ?array $transactions;

    public function handleResponse(): void
    {
        $response             = isset($this->response->data) ? $this->response->data : $this->response;
        $this->id             = $response->id;
        $this->customer       = $response->orderCustomer;
        $this->orderNumber    = $response->orderNumber;
        $this->saleChannel    = $response->salesChannel->name;
        $this->billingAddress = $response->billingAddress;
        $this->deliveries     = $response->deliveries;
        $this->orderLineItems = $response->lineItems;
        $this->addresses      = $response->addresses;
        $this->orderValue     = [
            "currency"    => $response->currency,
            "totalAmount" => $response->amountTotal,
        ];
        $this->transactions = $response->transactions;
        $this->createdAt = $response->createdAt;
    }
}
