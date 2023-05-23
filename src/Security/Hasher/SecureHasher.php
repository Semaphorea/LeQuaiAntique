<?php 

// src/Security/Hasher/CustomVerySecureHasher.php
namespace App\Security\Hasher;

use Symfony\Component\PasswordHasher\Exception\InvalidPasswordException;
use Symfony\Component\PasswordHasher\Hasher\CheckPasswordLengthTrait;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class SecureHasher implements PasswordHasherInterface
{
    use CheckPasswordLengthTrait;

    public function hash(string $plainPassword): string
    {
        if ($this->isPasswordTooLong($plainPassword)) {
            throw new InvalidPasswordException();
        }

        // ... hash the plain password in a secure way
        $cost=12;
        $hashedPassword = password_hash($plainPassword,PASSWORD_BCRYPT ,["cost" => $cost]);
             
        return $hashedPassword;
    }

    public function verify(string $hashedPassword, string $plainPassword): bool
    {
        if ('' === $plainPassword || $this->isPasswordTooLong($plainPassword)) {
            return false;
        }
        // ... validate if the password equals the user's password in a secure way
        $passwordIsValid= password_verify($plainPassword,$hashedPassword ) ;     

        return $passwordIsValid;
    }

    public function needsRehash(string $hashedPassword): bool
    {
        // Check if a password hash would benefit from rehashing
        $hashIsOutdated = password_needs_rehash( $hashedPassword,'bcrypt');

        return $hashIsOutdated;
      
    }
}