<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(ProductRepository $repository): Response
    {

        $products = $repository->getProductsHome(6);

        return $this->render('front/index.html.twig',[
            'products' => $products
        ]);
    }

    /**
     * @Route("/admin", name="admin_home")
     */
    public function admin(): Response
    {
        return $this->redirectToRoute("app_login");
    }
}
