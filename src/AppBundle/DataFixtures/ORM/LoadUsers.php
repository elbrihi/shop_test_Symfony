<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Foggyline\UserBundle\Entity\User;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
  private $container ;
  public function load(ObjectManager $manager)
  {
    $user = new User();
    $user->setUsername('admin');
    $user->setEmail('admin@admin.info');
   
    $encoder =  $this->container->get('security.password_encoder');
    //print_r($encoder);
    //die;
    $password = $encoder->encodePassword($user,'aaaa');
    $user->setPassword($password);
    $manager->persist($user);
    $manager->flush();

    $user->setUsername('zizo');
    $user->setEmail('zizo@admin.info');
    $encoder =  $this->container->get('security.password_encoder');
    $password = $encoder->encodePassword($user,'0000');
    $user->setPassword($password);
    $manager->persist($user);
    $manager->flush();
   


  }
  public function setContainer(ContainerInterface $container = null)
  {
    $this->container = $container;
  }
}