<?php

namespace Foggyline\CatalogBundle\Security;

use Foggyline\CatalogBundle\Entity\Category; 
use Foggyline\UserBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;



class CategoryVoter extends Voter
{
    const VIEW = 'view';
    const EDIT = 'edit';
    const DELETE = 'delete';
   
    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, array(self::VIEW, self::EDIT, self::DELETE))) {
            return false;
        }

        // only vote on Post objects inside this voter
        if (!$subject instanceof Category) {
            return false;
        }

        return true;
    }
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // you know $subject is a Post object, thanks to supports

        if( $user  !== $subject->getUser())
        {
            return false ;
        }

        return true ;
        
    }

}




?>