<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route(path:'/product/show-all', name:'product_show_all')]
    public function showAll(ProductRepository $productRepository) {
        $products = $productRepository->findAll();
        return $this->render('base.html.twig', ['products' => $products]);
    }
}