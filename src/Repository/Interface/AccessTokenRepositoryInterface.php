<?php 

namespace App\Repository\Interface;

use App\Entity\AuthEntity;
use Symfony\Component\Security\Core\User\User;


interface AccessTokenRepositoryInterface
{
    public function getAccessToken(AuthEntity $authEntity): ?String;

    public function getAuthEntity(string $token): ?AuthEntity;
} 