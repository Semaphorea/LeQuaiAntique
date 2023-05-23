<?php

//Transformer Changer une Entité en nombre (id) et inversement un id entré dans un formulaire en entité

// src/Form/DataTransformer/AuthEntityToNumberTransformer.php
namespace App\Form\DataTransformer;

use App\Entity\AuthEntity; 
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class AuthEntityToNumberTransformer implements DataTransformerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * Transforms an object (issue) to a string (number).
     *
     * @param  AuthEntity|null $issue
     */
    public function reverseTransform($issue): string
    {
        if (null === $issue) {
            return '';
        }
        
        return $issue->getId();
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param  string $issueNumber
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function transform($issueNumber): ?AuthEntity
    {
        // no issue number? It's optional, so that's ok
        if (!$issueNumber) {
            return null;
        }

        $issue = $this->entityManager
            ->getRepository(AuthEntity::class)
            // query for the issue with this id
            ->find($issueNumber)
        ;

        if (null === $issue) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $issueNumber
            ));
        }

        return $issue;
    } 
}