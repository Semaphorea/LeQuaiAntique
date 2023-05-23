<?php

namespace App\Security;

use App\Entity\AuthEntity;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use App\Security\UserProvider;

use App\Security\AccessTokenHandler;
use App\Repository\AccessTokenRepository;
use Doctrine\ORM\EntityManagerInterface; 
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


use Symfony\Config\SecurityConfig;
use App\Repository\AuthEntityRepository;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use App\Security\Hasher\SecureHasher;

class AuthEntityAuthentificator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';
    private $tokenStorage;  
    private EntityManagerInterface $em;
    private UserProvider $userProvider;
    private SecureHasher $passwordHasher;
    public $badge;
    private PasswordAuthenticatedUserInterface $passwordAuthUser;

    public function __construct(private UrlGeneratorInterface $urlGenerator,TokenStorageInterface $tokenStorage,UserProvider $userProvider,AccessTokenRepository $tokenRepository, AuthEntityRepository $entityRepository, EntityManagerInterface $em)
    {   
        $this->tokenStorage = $tokenStorage;
        $this->userProvider = $userProvider;     
        $this->badge= null;
        $this->em= $em;
    }
        
   
  
    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');


        $password = $request->request->get('password', '');
    
     
        $authEntity = $this->userProvider->loadUserByIdentifier($email);
        if (!$authEntity) {
            throw new CustomUserMessageAuthenticationException('Invalid email');
        }
        
        
         $storedpassword=null;  
        if($authEntity instanceof AuthEntity){
         $storedpassword=$authEntity->getPassword(); }
        else{throw new CustomUserMessageAuthenticationException('L\'objet $authEntity n\'est pas instance de la class AuthEntity ');}
        
        
         $secure=  new SecureHasher();        
         $isValid =$secure->verify($storedpassword, $password); 

      
        if (!$isValid) {
            throw new CustomUserMessageAuthenticationException('Invalid password');
        }   

        

        $request->getSession()->set(Security::LAST_USERNAME, $email);
 


       // $passwordcredential=new PasswordCredentials($request->request->get('password', ''));
        //dd($passwordcredential);  
          //      $cred=   new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token'));
          
          //var_dump($cred ); 
         $passport = new Passport(
            
          $this->badge=  new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        ); 
        
 
        return $passport;
       
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        
      
        $role= $token->getUser()->getRoles();     
        //dd($role);
                    
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }   
 
        $headers=['Authorization',$token->__serialize()]; 

         if($role == 'ROLE_ADMIN'){
             return new RedirectResponse($this->urlGenerator->generate('app_administration'),302,$headers);  };
         if($role == 'ROLE_USER'){
             return new RedirectResponse($this->urlGenerator->generate('app_réservation'),302,$headers);  

        throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);}

        return new RedirectResponse($this->urlGenerator->generate('app_accueil'));  
    }  


    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }


   public static function getToken( SecurityConfig $security) {
   $res= $security->firewall('main')
        ->accessToken()
            ->tokenHandler(AccessTokenHandler::class)
            ->tokenExtractors([
                'header'                
            ]);

        
            return $res;
}

}
