<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\CategoryShop;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ProductController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    #[Route('/boutique', name: 'shop_index')]
    public function index(): Response
    {
        $products = $this->em->getRepository(Product::class)->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }
}
