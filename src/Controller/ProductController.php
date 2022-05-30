<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Search;
use App\Form\ProductType;
use App\Form\SearchType;
use App\Repository\ProductRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name= "product_")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name= "index")
     */
    public function index(Request $request, ProductRepository $repository): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        $products = $repository->findSearch($search);
        return $this->render('product/index.html.twig', [
            'products'  => $products,
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/add", name="add", methods={"POST"})
     */
    public function addProduct(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $pictureFile */
            $brochureFile = $form->get('picture')->getData();
            if ($brochureFile) {
                $pictureFileName = $fileUploader->upload($brochureFile);
                $product->setPictureFilename($pictureFileName);
            }

            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Votre produit a été ajouté avec succès !'
            );

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/modal.html.twig', [

            'form' => $form->createView(),
        ]);
    }




}