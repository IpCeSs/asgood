<?php
/**
 * Created by PhpStorm.
 * User: ipcess
 * Date: 24/07/18
 * Time: 14:29
 */

namespace App\Mail;


use App\Entity\Ad;
use App\Entity\User;

class MailService
{

    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;

    }

    public function sendMailOnRegisterOK(User $receiver){
        //to send an email to the new user to confirm his registration
        $message = (new \Swift_Message('Welcome to AsGoodAsNew !'))
            ->setFrom('admin@asgoodasnew.com')
            ->setTo($receiver->getEmail())
            ->setBody('You successfully signed up to AsGoodAsNew ! We are glad to have you with us ! You can now go find the best deals of your region!', 'text/html');

        $this->mailer->send($message);
    }


    public function sendEmailAdEditionByAdmin( User $sender, User $receiver, Ad $adId){

        $message = (new \Swift_Message('One of your ad was edited!'))
            ->setFrom($sender->getEmail())
            ->setTo($receiver->getEmail())
            ->setBody('Your ad'. $adId->getTitle() .'was edited by our website administrator because it doesn\'t respect the rules of publishing of as good as new', 'text/html');

        $this->mailer->send($message);
    }

    public function sendEmailAdDeletionByAdmin( User $sender, User $receiver, Ad $adId){


        $message = (new \Swift_Message('WARNING your ad was deleted.'))
            ->setFrom($sender->getEmail())
            ->setTo($receiver->getEmail())
            ->setBody('Your ad'. $adId->getTitle() .' was deleted beacause i wanted to! ', 'text/html');

        $this->mailer->send($message);
    }

}