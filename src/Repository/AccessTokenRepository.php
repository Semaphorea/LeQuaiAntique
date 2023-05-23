<?php

namespace App\Repository;

use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Cache\CacheItem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use App\Repository\Interface\AccessTokenRepositoryInterface;
use App\Entity\AuthEntity;

/**
 * AccessTokenRepository
 * Fonctionne en récupérant le token dans le système de Stockage en Cache tockenStorage
 * Je ne passe pas par la base de donnée pour des questions de sécurité mais aussi parce qu'il s'agit d'une donnée éphémère.
 * */
class AccessTokenRepository implements AccessTokenRepositoryInterface 
{
    private $tokenStorage;
    private $cache;

    public function __construct(TokenStorageInterface $tokenStorage, CacheItemPoolInterface $cache)
    {
        $this->tokenStorage = $tokenStorage;
        $this->cache = $cache;
    }

    public function getAuthEntity(string $token): ?AuthEntity
    {
        $user = $this->tokenStorage->getToken()->getUser();
        if (!$user instanceof AuthEntity) {
            throw new AuthenticationException('User is not authenticated.');
        }else{
        

         return $user; 
        }
    }




    public function getAccessToken(AuthEntity $authEntity): string
    {
        $user = $this->tokenStorage->getToken()->getUser();
        if (!$user instanceof AuthEntity) {
            throw new AuthenticationException('User is not authenticated.');
        }
        else{
        $token= $this->tokenStorage->getToken();

       
        return $token;}
    }
}
