<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\ProductType;
use App\Entity\Product;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Knp\Component\Pager\PaginatorInterface;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

use Dompdf\Dompdf;
use Dompdf\Options;

class ProductController extends AbstractController
{
    
    
    #[Route('/', name: 'products')]
    public function index(ManagerRegistry $doctrine ,PaginatorInterface $paginator ,Request $request){
        
        $entityManager = $doctrine->getManager();


        $query = $doctrine->getRepository(Product::class)->findAll();
        $pagination = $paginator->paginate(
            $query, 
            $request->query->getInt('page', 1), 5 );


        return $this->render('product/products.html.twig',['productos' => $pagination]);

    }


    #[Route('/create', name: 'create')]
    public function createProduct(ManagerRegistry $doctrine,Request $request){

        $entityManager = $doctrine->getManager();

        $product = new Product();

        $formProduct = $this->createForm(ProductType::class,$product);

        $formProduct ->handleRequest($request);
        
        if ($formProduct->isSubmitted() && $formProduct->isValid()) { 
            
            $em = $doctrine->getManager();
            $em -> persist($product);
            $em -> flush();

            $this->addFlash('notice','Formulario enviado coorectamente!!');
  
        }

        return $this->render('product/create.html.twig',['formProduct' => $formProduct->createView()]);


    }

    #[Route('/edit/{id}', name: 'edit')]
    public function updateProduct(ManagerRegistry $doctrine,Request $request, $id){

        $entityManager = $doctrine->getRepository(Product::class)->find($id);

        $formProduct = $this->createForm(ProductType::class,$entityManager);

        $formProduct ->handleRequest($request);
        
        if ($formProduct->isSubmitted() && $formProduct->isValid()) { 
            
            $em = $doctrine->getManager();
            $em -> persist($entityManager);
            $em -> flush();

            $this->addFlash('notice','Formulario Atualizado coorectamente!!');
  
        }

        return $this->render('product/edit.html.twig',['formProduct' => $formProduct->createView()]);


    }


    #[Route('/delete/{id}', name: 'delete')]
    public function deleteProduct(ManagerRegistry $doctrine,Request $request, $id){

        $entityManager = $doctrine->getRepository(Product::class)->find($id);

        $em = $doctrine->getManager();
        $em -> remove($entityManager);
        $em -> flush();
        
        return $this->redirectToRoute('products');


    }

    #[Route('/pdf', name: 'generatepdf')]
    public function generatePdf(ManagerRegistry $doctrine){

     
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        

        $dompdf = new Dompdf($pdfOptions);

        $product = $doctrine->getRepository(Product::class)->findAll();

 

        $html =  $this->renderView('product/pdf/pdfProducts.html.twig',['productos' => $product]);
        
        
 
        $dompdf->loadHtml($html);
        
        
        $dompdf->setPaper('A4', 'portrait');

       
        $dompdf->render();

        // Envíe el PDF generado al navegador (vista en línea)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);

    }







}
