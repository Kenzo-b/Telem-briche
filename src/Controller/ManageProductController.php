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
                'form' => $form,
                'product' => $product
            ]
        );

    }

    #[Route('/manage/product/delete/{id}', name: 'manage_product_delete', requirements: ["id" => '\d+'])]
    public function delete(Product $product, Request $request ,EntityManagerInterface $em): Response {
        $submittedToken = $request->request->get('token');
        if($this->isCsrfTokenValid("delete-product", $submittedToken)) {
            $id = $product->getId();
            $em->remove($product);
            $em->flush();

            $this->addFlash('success', "Le produit $id a été supprimé");
            return $this->redirectToRoute('product_show_all');
        }
        $this->addFlash('error', "le token pour la suppression du produit est invalide");
        return $this->redirectToRoute('manage_product_edit', ['id' => $product->getId()]);
    }

    #[Route('/manage/product/delete-confirm/{id}', name: 'manage_product_delete_confirm', requirements: ["id" => '\d+'])]
    public function deleteConfirm(Product $product): Response {
        return $this->render('product/product_delete_confirm.html.twig',['product'=>$product]);
    }
}