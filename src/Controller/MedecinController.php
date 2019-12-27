<?php

namespace App\Controller;

use App\Entity\Medecin;
use App\Form\MedecinType;

use App\Repository\MedecinRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MedecinController extends AbstractController
{
    /**
     * @Route("/medecin", name="medecin.medecin.show")
     */
    public function showmedecin(MedecinRepository $repo)
    {
        $medecins= $repo->findAll();
        return $this->render('medecin/index.html.twig', [
            'medecins' => $medecins,
        ]);
    }
    /**
     * @Route("/medecin/add", name="medecin.medecin.add")
     */
    public function addmedecin(Request $request)
    {
        $idmatricule=$this->getLastMedecin() +1;

       $medecin= new Medecin();
       // ...

       $form = $this->createForm(MedecinType::class, $medecin);
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
       $twofirstletters=\strtoupper(\substr($medecin->getServices()->getLibelle(),0,2));
       $longId=strlen((string)$idmatricule);
       $matricule = \str_pad("M".$twofirstletters,8 - $longId,"0").$idmatricule;
       $medecin->setMatricule($matricule);
           // ... perform some action, such as saving the task to the database
           // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($medecin);
            $entityManager->flush();
   
           return $this->redirectToRoute('medecin.medecin.show');
       }
       return $this->render('medecin/form.html.twig', [
           'form' => $form->createView(),
       ]);
       }
        /**
     * @Route("/medecin/edit/{Id}", name="medecin.medecin.edit")
     */
    public function editmedecin($Id,Request $request,MedecinRepository $repo)
    {
        $medecins = $repo-> find($Id);
        // ...

        $form = $this->createForm(MedecinType::class, $medecins);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($medecins);
            $entityManager->flush();
    
            return $this->redirectToRoute('medecin.medecin.show');
        }
    
        return $this->render('medecin/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/medecin/delete/{Id}", name="medecin.medecin.delete")
     */
    public function deletemedecin($Id,MedecinRepository $repo)
    {
        $medecins = $repo-> find($Id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($medecins);
       $entityManager->flush();

       return $this->redirectToRoute('medecin.medecin.show');
    }
    public function getLastMedecin()
    {
        $repo = $this->getDoctrine()->getRepository(Medecin::class);
        $medecinLast=$repo->findBy([],['id'=> 'DESC']);
        if($medecinLast==null){
            return $Id=0;
        }else{
            return $medecinLast[0]->getId();
        }
    }                   
}
