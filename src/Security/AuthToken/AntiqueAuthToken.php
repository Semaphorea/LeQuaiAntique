<?php 
namespace Security\AuthToken;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

class AntiqueAuthToken extends AbstractToken
{
    private $token;

    public function __construct($token)
    {
        parent::__construct();

        $this->token = $token;
        
    }

    public function getCredentials()  
    {
        return '';
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token=$token;    
    }
}
