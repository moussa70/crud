<?php

namespace App\Controller;

use App\Entity\Specialite;
use App\Form\SpecialiteType;
use App\Repository\SpecialiteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SpecialiteController extends AbstractController
{
    /**
     * @Route("/specialite", name="specialite.specialite.show")
     */
    public function showspecialite(SpecialiteRepository $repo)
    {
        $specialites =$repo->findAll();
        return $this->render('specialite/index.html.twig', [
            'specialites' => $specialites,
        ]);
    }
     /**
     * @Route("/specialite/add", name="specialite.specialite.add")
     */
    public function addspecialite(Request $request)
    {
        $specialites = new Specialite();
        // ...

        $form = $this->createForm(SpecialiteType::class, $specialites);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
    
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($specialites);
            $entityManager->flush();
    
            return $this->redirectToRoute('specialite.specialite.show');
        }
    
        return $this->render('specialite/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/specialite/edit/{Id}", name="specialite.specialite.edit")
     */
    public function editspecialite($Id,Request $request,SpecialiteRepository $repo)
    {
        $specialites = $repo-> find($Id);
        // ...

        $form = $this->createForm(SpecialiteType::class, $specialites);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($specialites);
            $entityManager->flush();
    
            return $this->redirectToRoute('specialite.specialite.show');
        }
    
        return $this->render('specialite/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
     /**
     * @Route("/specialite/delete/{Id}", name="specialite.specialite.delete")
     */
    public function deletespecialite($Id,SpecialiteRepository $repo)
    {
        $specialites = $repo-> find($Id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($specialites);
       $entityManager->flush();

       return $this->redirectToRoute('specialite.specialite.show');
    }
}
