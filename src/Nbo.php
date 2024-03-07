<?php

namespace Shibanashiqc\NboPaymentGatewayPhp;

class Nbo extends Request
{
    public function __construct($merchant_id, $password, $resource_key,  $action = 1)
    {
        parent::__construct($merchant_id, $password, $resource_key, $action);
    }
    
}