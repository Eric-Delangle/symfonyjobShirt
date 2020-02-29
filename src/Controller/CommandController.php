<?php

namespace App\Controller;

use Acme\PaymentBundle\Entity\Payment;
use App\Services\Basket\BasketService;
use Acme\PaymentBundle\Entity\PaymentToken;
use HiPay\Fullservice\HTTP\SimpleHTTPClient;
use Symfony\Component\Routing\Annotation\Route;
use HiPay\Fullservice\Gateway\Client\GatewayClient;
use HiPay\Fullservice\HTTP\Configuration\Configuration;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandController extends AbstractController
{
    /**
     * @Route("/command", name="command")
     */
    public function index(BasketService $basketService)
    {
        return $this->render('command/index.html.twig', [
            'items' => $basketService->getFullBasket(),
            'total' => $basketService->getTotal()
        ]);
    }

     /**
     * @Route("/command", name="command_pay")
     */
    public function pay(SessionInterface $session, BasketService $basketService, Configuration $config, SimpleHTTPClient $clientProvider, GatewayClient $gatewayClient)
    {
       
      //Create a configuration object
        // By default Configuration object is configured in Stage mode (Configuration::API_ENV_STAGE)
        $config = new \HiPay\Fullservice\HTTP\Configuration\Configuration("username","password");

        //Instantiate client provider with configuration object
        $clientProvider = new \HiPay\Fullservice\HTTP\SimpleHTTPClient($config);

        //Create your gateway client
        $gatewayClient = new \HiPay\Fullservice\Gateway\Client\GatewayClient($clientProvider);

        $orderRequest = new \HiPay\Fullservice\Gateway\Request\Order\OrderRequest();
        $orderRequest->orderid = $session->getId();
        $orderRequest->operation = "Sale";
        $orderRequest->payment_product = "visa";
        $orderRequest->description = "ref_85";
        $orderRequest->firstname = $session->getFirstName();
        $orderRequest->lastname = $session->getLastName();
        $orderRequest->email = $session->getEmail();
        $orderRequest->currency = "EUR";
        $orderRequest->amount = $basketService->getTotal();
        $orderRequest->shipping = "0.00";
        $orderRequest->tax = "3.6";
        $orderRequest->cid = null;
        $orderRequest->ipaddr = "172.20.0.1";
        $orderRequest->accept_url = "http:/localhost/checkout/accept";
        $orderRequest->decline_url = "http:/localhost/checkout/decline";
        $orderRequest->pending_url = "http:/localhost/checkout/pending";
        $orderRequest->exception_url = "http:/localhost/checkout/exeception";
        $orderRequest->cancel_url = "http:/localhost/checkout/cancel";
        $orderRequest->http_accept = "*/*";
        $orderRequest->http_user_agent = "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36";
        $orderRequest->language = "fr_FR";
       // $orderRequest->custom_data = "{"shipping_description":"Flat rate","payment_code":"visa","display_iframe":0}";
        $orderRequest->authentication_indicator = 0;
        return $this->render('command/index.html.twig');
    }
}
