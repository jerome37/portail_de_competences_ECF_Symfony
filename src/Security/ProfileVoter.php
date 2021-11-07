<?php

use App\Entity\User;
use App\Entity\Profile;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ProfileVoter extends Voter 
{
    const COLLABORATEUR = 'ROLE_COLLABORATEUR';
    const COMMERCIAL = 'ROLE_COMMERCIAL';
    const ADMINISTRATEUR = 'ROLE_ADMIN';

    protected function supports(string $attribute, $subject): bool
    {
        // Si l'attribut n'est pas parmis l'un de ceux que l'on attend, alors l'accès est refusé
        if (!in_array($attribute, [self::COLLABORATEUR])) {
            return false;
        }

        // Si l'objet passé en second argument n'est pas une instance de 'Profile', l'accès est refusé
        if (!$subject instanceof Profile) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        // TokenInterface est une interface qui permet de récupérer l'utilisateur en cours
        $user = $token->getUser();

        // Vérification de la conneion de l'utilisateur
        // S'il n'est pas connecté, l'accès lui est refusé
        if (!$user instanceof User) {
            return false;
        }

        // Grâce à la fonction 'support()', on sait que l'objet passé est une instance de 'Profile'
        /** @var Profile $profile */
        $profile = $subject;
        
        // Selon l'attribut, l'utilisateur peut voir et éditer le profil
        // Si c'est un collaborateur, on vérifie que l'utilisateur est bien le même collaborateur propriétaire du profile
        // Sinon, l'autorisation est accordée
        switch ($attribute) {
            case self::COLLABORATEUR:
                return $profile->getId() === $user->getProfile()->getId();
            case self::COMMERCIAL:
                return true;
            case self::ADMINISTRATEUR:
                return true;
        }

        throw new \LogicException('This code should not be reached!');
    }

}