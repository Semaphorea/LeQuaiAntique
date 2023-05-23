<?php

namespace App\EventSubscriber;

use App\Event\ContactEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mime\Email;     
use Symfony\Component\Mailer\MailerInterface;

  
class ContactSubscriber implements EventSubscriberInterface
{
  private MailerInterface $mailer;   

  function __construct(MailerInterface $mailer){
  $this->mailer=$mailer;
  }
  
  public function  onContactEvent(ContactEvent $contact){  
  
        $email=$contact->getEmail();
        $message=$contact->getMessage();      
       
    
        $mail= (new Email())
         ->from( $email)
         //->to('administrateur@localhost')
         ->to('semaphorea@protonmail.com')
         ->subject('Vous avez reçu un Message de '.$email) 
         ->html($message);  
        // dd (typeOf($mi));         
        $this->mailer->send($mail);  

}
   
    public static function getSubscribedEvents(): array
    {
        return [
            ContactEvent::class => 'onContactEvent',
        ];
    }
}
