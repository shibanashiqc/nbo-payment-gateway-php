<?php 

require_once 'vendor/autoload.php';

use Shibanashiqc\NboPaymentGatewayPhp\Nbo;

$request = new Nbo('IPAYlCR6qZF7q6w', 'TEST123456@', '34343434343497');
// $request->client->setURL('production_url_get_from_nbo_dashboard');
$request->setErrorURL('http://localhost:8000/error');
$request->setResponseURL('http://localhost:8000/response');
$result = $request->getPaymentRequest(20, 'Sj', '458485747', 'shibanashiqc@gmail.com', strval(rand(100000, 999999)));
echo $result->redirectUrl();
