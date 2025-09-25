<?php
namespace App\Service;

use App\Entity\Persons;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;

class PersonsManager{

    private EntityManagerInterface $em;
    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }
    public function getTable(){

        $meta = $this->em->getClassMetadata(Persons::class);
        $headers = $meta->getFieldNames();
        $repos = [];
        try{
            $repos = $this->em->getRepository(Persons::class)->findAll();
        }catch(\Exception $e){
            return [];
        }
        return [$repos,$headers];
    }
    public function createPersons(Persons $persons){
        try{
            if($this->em->getRepository(Persons::class)->findOneBy([
                "email" => $persons->getEmail(),
                ]))
                return false;

            if($this->em->getRepository(Persons::class)->findOneBy([
                "username" => $persons->getUsername(),
                ]))
                return false;
            $this->em->persist($persons);
            $this->em->flush();
            return true;
        } catch(\Exception $e){
            return false;
        }
    }

    public function updatePersons(){
        $this->em->flush();
        return true;
    }
    public function getPersons($id){
        return $this->em->getRepository(Persons::class)->find($id);
    }

    public function createTable(){
        try{

            $metadata =[ $this->em->getClassMetadata(Persons::class)];

            $schematool = new SchemaTool($this->em);
            
            $schematool->createSchema($metadata);
            return true;
        } catch(\Exception $e){
            return false;
        }
    }
}