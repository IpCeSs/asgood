<?php

namespace App\Security\Voter;

use App\Entity\Ad;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;


class AdVoter extends Voter
{
    const EDIT = 'edit';
    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, array(self::EDIT))) {
            return false;
        }

        // only vote on Post objects inside this voter
        if (!$subject instanceof Ad) {
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
        // ROLE_ADMIN can do anything! The power!
        if ($this->decisionManager->decide($token, array('ROLE_ADMIN'))) {
            return true;
        }

        // you know $subject is a Post object, thanks to supports
        /** @var Ad $ad */
        $ad = $subject;

        switch ($attribute) {

            case self::EDIT:
                return $this->canEditOrDelete($ad, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canEditOrDelete(Ad $ad, User $user)
    {
        // this assumes that the data object has a getOwner() method
        // to get the entity of the user who owns this data object
        return $user === $ad->getUser();
    }
}
