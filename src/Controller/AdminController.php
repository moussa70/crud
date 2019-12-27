<?php

namespace App\Controller;



use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin.service.show")
     */
    public function showservice(ServiceRepository $repo)
    {
        $services=$repo->findAll();
        return $this->render('admin/index.html.twig', [
            'services' => $services,
        ]);
    }
    /**
     * @Route("/admin/add", name="admin.service.add")
     */
    public function addservice(Request $request)
    {
        $services = new Service();
        // ...

        $form = $this->createForm(ServiceType::class, $services);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
    
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($services);
            $entityManager->flush();
    
            return $this->redirectToRoute('admin.service.show');
        }
    
        return $this->render('admin/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/admin/edit/{Id}", name="admin.service.edit")
     */
    public function editservice($Id,Request $request,ServiceRepository $repo)
    {
        $services = $repo-> find($Id);
        // ...

        $form = $this->createForm(ServiceType::class, $services);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($services);
            $entityManager->flush();
    
            return $this->redirectToRoute('admin.service.show');
        }
    
        return $this->render('admin/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
     /**
     * @Route("/admin/delete/{Id}", name="admin.service.delete")
     */
    public function deleteservice($Id,ServiceRepository $repo)
    {
        $services = $repo-> find($Id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($services);
       $entityManager->flush();

       return $this->redirectToRoute('admin.service.show');
    }
}
