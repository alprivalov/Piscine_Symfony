<?php
namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserManager{

    private EntityManagerInterface $em;
    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }
    public function getTable(){
        return $this->em->getRepository(User::class)->findAll();
    }
    public function createUser(User $user){
        if($this->em->getRepository(User::class)->findOneBy([
            "email" => $user->getEmail(),
            ]))
            return false;

        if($this->em->getRepository(User::class)->findOneBy([
            "username" => $user->getUsername(),
            ]))
            return false;
        $this->em->persist($user);
        $this->em->flush();
        return true;
    }
    public function deleteUser($userId){
        $user =  $this->em->getRepository(User::class)->find($userId);
        if($user){
            $this->em->remove($user);
            $this->em->flush();
        }
    }
}