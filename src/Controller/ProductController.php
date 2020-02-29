<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Products;
use App\Repository\CategoryRepository;
use App\Repository\ProductsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Collections\ArrayCollection;

class ProductController extends AbstractController
{

       
     // ici je tente d'envoyer le bon rayon au click sur la categorie voulue
    /**
     * @Route("/product/category/{id}", name="product_category", methods={"GET"}, requirements={"id": "\d+"})
     */
    public function category($id, Request $request, Category $category, ProductsRepository $productRepo, CategoryRepository $catRepo)
     {

        return $this->render('genre/index.html.twig',[ 
        
         'product' => $productRepo->findAll(),
         'category' =>$category,
        ]);
    }

    /**
     * @Route("/product", name="product")
     */
    public function index()
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

     /**
     * @Route("/product/{id}", name="product_show")
     */
    public function show($id, ProductsRepository $productRepo, Products $product, Request $request, CategoryRepository $catRepo)
    {
        return $this->render('product/show.html.twig', [
            'category' => $catRepo->findBy(array('id'=>$id)),
            'product' => $product,
            $productRepo->find($id),
        
        ]);
    }

}
