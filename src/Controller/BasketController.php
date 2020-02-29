<?php

namespace App\Controller;

use App\Services\Basket\BasketService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BasketController extends AbstractController
{
   
    /**
     * @Route("/basket", name="basket_index")
     */
    public function index(BasketService $basketService)
    {
        return $this->render('basket/index.html.twig', [
            'items' => $basketService->getFullBasket(),
            'total' => $basketService->getTotal()
        ]);
    }

    /**
     * @Route("/basket/add/{id}", name="basket_add")
     */
    public function add($id, BasketService $basketService) {
      
        $basketService->add($id);
        return $this->redirectToRoute('basket_index');        
    }

    /**
     * @Route("/basket/remove/{id}", name="basket_remove")
     */
    public function remove($id, BasketService $basketService) {

        $basketService->remove($id);
        return $this->redirectToRoute("basket_index");
    }
}
