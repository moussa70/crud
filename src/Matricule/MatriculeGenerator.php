<?php
namespace App\Matricule;

use App\Entity\Medecin;
use App\Matricule\MatriculeGenerator;
use App\Repository\MedecinRepository;

class MatriculeGenerator {
    private $matricule;
    public function __construct(MedecinRepository $repo)
    {
        $autoMat= $repo->findAll();
        $count = count($autoMat);
        $this->matricule = sprintf("405d", $count+1);
    }
    public function generateMat(Medecin $medecins){
        $index="M";
        $services= $medecins->getService()->getLibelle();
        $numbofworld= (str_word_count($services, 1));
        if (count($numbofworld) >=2 ){
            foreach($numbofworld as $key => $value) {
                $index.= strtoupper(substr($value, 0,1));
            }
        }else{
            $index.= strtoupper(substr($numbofworld[0], 0,3));
        }
        return $index.$this->matricule;
    }
}