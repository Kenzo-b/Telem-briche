<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractController
{
    #[Route('/product/show-all', name: 'product_show_all')]
    public function showAll(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('product/product_show_all.html.twig', ['products' => $products]);
    }

    #[Route('/product/show/{id}', name: 'product_show', requirements: ['id' => '\d+'])]
    public function show(int $id, ProductRepository $productRepository): Response
    {
        $product = $productRepository->find($id);
        if (!$product) {
            throw new NotFoundHttpException("ce produit n'existe pas");
        }
        return $this->render('product/product_show.html.twig', ['product' => $product]);
    }

    #[Route('/product/search', name: 'product_search', methods: ['POST'])]
    public function search(Request $request, ProductRepository $productRepository): Response
    {
        $KeywordSearched = $request->request->get('searchProduct');
        $products =  $productRepository->search($KeywordSearched);
        return $this->render('product/product_show_all.html.twig', ['products' => $products]);
    }
}