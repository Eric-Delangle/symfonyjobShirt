<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Category;
use App\Entity\Products;
use App\Repository\CategoryRepository;
use App\Repository\ProductsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ProductsRepository $productRepo, PaginatorInterface $paginator, Request $request, CategoryRepository $catRepo)
    {
      
        return $this->render('home/index.html.twig',[ 
            'product' => $paginator->paginate(
            $productRepo->findAll(),
            $request->query->getInt('page' , 1 ),
            1),
            'category' => $catRepo->findAll(),
           // 'products' => $prod
            
          
        ]);   
    }

    
  
}
