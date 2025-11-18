<?php
namespace App\Service;
use Symfony\Component\Form\AbstractType;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserManager {
    public function __construct(private EntityManagerInterface $em) {}
    public function saveUser(User $user){
        try{

            if($this->em->getRepository(User::class)->findOneBy([
                "email"=> $user->getEmail()
            ]))
                return "email already exist";

            if($this->em->getRepository(User::class)->findOneBy([
                "username"=> $user->getUsername()
            ]))
                return "username already exist";

            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash( 'success','Success : user create');

        } catch (\Exception $e){
            $this->addFlash( 'error','Error : user create');
        }
        return "user created!";
    }

    public function getTable():array{
        $array = $this->em->getRepository(User::class)->findAll();
        return $array;
    }
}