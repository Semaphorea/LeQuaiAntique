<?php 

// src/Security/AccessTokenHandler.php
namespace App\Security;

use App\Entity\AuthEntity;
use App\Repository\AccessTokenRepository;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use  Symfony\Component\Security\Core\Exception\BadCredentialsException;


class AccessTokenHandler implements AccessTokenHandlerInterface
{
    private AccessTokenRepository $repository;

    public function __construct(AccessTokenRepository $repository) {
        $this->repository=$repository;
    }

    public function getUserBadgeFrom(string $accessToken): UserBadge
    {
        //récupération de AuthEntity attenant à l'accessToken
        $AuthEntity = $this->repository->getAuthEntity($accessToken);
        if (null === $AuthEntity || !$AuthEntity instanceof(AuthEntity::class)) {
            throw new BadCredentialsException('Invalid credentials.');
        }

        // and return a UserBadge object containing the user identifier from the found token
        return new UserBadge($AuthEntity->getUserIdentifier()); 
    }
    
}