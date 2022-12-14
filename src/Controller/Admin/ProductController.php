<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Sercive\UploaderHelper;
use DateTimeImmutable;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

/**
 * @Route("admin/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="app_product_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $products = $productRepository->findAll();

        $pagination = $paginator->paginate(
            $products, // query NOT result 
            $request->query->getInt('page', 1), //page number
            10 //limit per page
        );

        return $this->render('admin/product/index.html.twig', [
            'products' => $pagination,
        ]);
    }


    /**
     * @Route("/new", name="app_product_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ProductRepository $productRepository, UploaderHelper $uploaderHelper): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setCreatedAt(new \DateTimeImmutable());

            /** @var UploadedFile $photoFile */
            $photoFile = $form->get('image')->getData();

            // this condition is needed because the 'image' field is not required
            // so the photo file must be processed only when a file is uploaded
            if ($photoFile) {
                
                // updates the 'photoFilename' property to store the PDF file name
                // instead of its contents
                $newFilename = $uploaderHelper->UploadProductImage($photoFile);
                $product->setPhoto($newFilename);
            }

            $productRepository->add($product, true);

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('admin/product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_product_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Product $product, ProductRepository $productRepository, MailerInterface $mailer, UploaderHelper $uploaderHelper): Response
    {
        $form = $this->createForm(ProductType::class, $product);
       
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setUpdatedAt(new \DateTimeImmutable());


             /** @var UploadedFile $photoFile */
             $photoFile = $form->get('photo')->getData();

             // this condition is needed because the 'brochure' field is not required
             // so the PDF file must be processed only when a file is uploaded
             if ($photoFile) {
                 
                $newFilename = $uploaderHelper->UploadProductImage($photoFile);
                 $product->setPhoto($newFilename);
             }

            $productRepository->add($product, true);
            
            /** Envoi mail */
           /*  $email = (new TemplatedEmail())
            ->from('adel@webspirit.tn')
            ->to('adel.ferchichi93@gmail.com')
            ->subject('Test mail with symfony')
            ->htmlTemplate("email/welcome.html.twig");
            $mailer->send($email); */
            /** Envoi mail */


            
            

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->renderForm('admin/product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_product_delete", methods={"POST"})
     */
    public function delete(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $productRepository->remove($product, true);
        }

        return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
    }
}
