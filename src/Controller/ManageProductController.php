<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\Type\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManageProductController extends AbstractController
{

    #[Route('/manage/product/new', name: 'manage_product_new')]
    public function new(Request $request, EntityManagerInterface $em): Response {
        $product = new Product();
        $form = $this->createForm(
            ProductType::class,
            $product,
            ['action' => $this->generateUrl('manage_product_new')]
        );

        $form->add('Ajouter', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setCreatedAt(new \DateTimeImmutable());
            $em->persist($product);
            $em->flush();
            $this->addFlash('success', 'le produit a été ajouté au catalogue');
            return $this->redirectToRoute('product_show_all');
        }

        return $this->renderForm('product/product_new.html.twig',
            [
                'form' => $form
            ]
        );
    }

    #[Route('/manage/product/edit/{id}', name: 'manage_product_edit', requirements: ["id" => '\d+'])]
    public function edit(Product $product, Request $request, EntityManagerInterface $em): Response {
        $form = $this->createForm(ProductType::class, $product);
        $form->add('updateProduct', SubmitType::class,
        [
            'label' => "Modifier le produit",
            'attr' => [
                'class' => 'Button -no-danger -reverse'
            ]
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setCreatedAt(new \DateTimeImmutable());
            $em->flush();
            $this->addFlash('success', 'le produit a été ajouté au catalogue');
            return $this->redirectToRoute('product_show',
            ['id' => $product->getId()]
            );
        }

        return $this->renderForm('product/product_new.html.twig',
            [
                'form' => $form
            ]
        );
    }
}