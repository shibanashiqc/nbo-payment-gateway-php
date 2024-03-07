# nbo-payment-gateway-php

Unofficial PHP library for [NBO Unified Checkout](https://www.nbo.om/en/Pages/Corporate-Banking/Support/POS-Solutions.aspx).

Read up here for getting started and understanding the payment flow with NBO Unified Checkout: <https://www.nbo.om/en/Pages/Corporate-Banking/Support/POS-Solutions.aspx>

### Prerequisites
- A minimum of PHP 8.1 is required.


## Installation

-   If your project using composer, run the below command

```
composer require shibanashiqc/no-payment-gateway-php

```

- If you are not using composer, download the latest release from [the releases section](https://github.com/shibanashiqc/nbo-payment-gateway-php/releases).
    **You should download the `nbo-payment-gateway-php-1.zip` file**.
    After that, include `Nbo.php` in your application and you can use the API as usual.

##Note:
This PHP library follows the following practices:

- Namespaced under `Shibanashiqc\NboPaymentGatewayPhp\`
- API throws exceptions instead of returning errors
- Options are passed as an array instead of multiple arguments wherever possible
- All requests and responses are communicated over JSON

## Documentation

Documentation of NBO Unified Checkout's API and their usage is available at <https://www.nbo.om/en/Pages/Corporate-Banking/Support/POS-Solutions.aspx>

## Basic Usage

Merchant credentials can be obtained from the NBO. You can use the following credentials for testing:

Required parameters for the constructor are:
Merchant ID, Password, ResourceKey

```php
use Shibanashiqc\NboPaymentGatewayPhp\Nbo;

$request = new Nbo('IPAYlCR6qZF7q6w', 'TEST123456@', '34343434343497');
// $request->client->setURL('production_url_get_from_nbo_dashboard'); // if you got production keys the enable this
$request->setErrorURL('http://localhost:8000/error');
$request->setResponseURL('http://localhost:8000/response');

```

### Create a Payment

getPaymentRequest() on this function first parameter is amount, second parameter is customer name, third parameter is customer mobile number, fourth parameter is customer email, fifth parameter is order id


```php
$result = $request->getPaymentRequest(20, 'Sj', '458485747', 'user@gmail.com', strval(rand(100000, 999999)));
echo $result->redirectUrl();

```

redirect url to redirect your user to NBO payment page complete the payment after payment complete NBO will redirect to your callback url with payment details 


## License

The NBO Unified Checkout PHP SDK is released under the MIT License. See [LICENSE](LICENSE) file for more details.
