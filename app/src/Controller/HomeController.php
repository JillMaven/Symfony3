<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MessageGenerator;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProductRepository $productRepository, MessageGenerator $messageGenerator): Response
    {
        $products = $productRepository->findAll();

        // dd($products);

        $productBestSeller = $productRepository->findByIsBestSeller(1);

        $productSpecialOffert = $productRepository->findByIsSpecialOffer(1);

        $productNewArrival = $productRepository->findByIsNewArrival(1);

        $productFeatured = $productRepository->findByIsFeatured(1);

        $message = $messageGenerator->getHappyMessage();
        
        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
            'products' => $products,
            'productBestSeller' => $productBestSeller,
            'productSpecialOffert' => $productSpecialOffert,
            'productNewArrival' => $productNewArrival,
            'productFeatured' => $productFeatured,
            "message" => $message
        ]);
    }
}
