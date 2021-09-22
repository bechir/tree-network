<?php

/*
 * This file is part of the Tree Network application.
 *
 * (c) Bechir Ba <bechiirr71@gmail.com>
 */

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class UserPasswordValidator extends ConstraintValidator
{
    private $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoder)
    {
        $this->encoderFactory = $encoder;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof UserPassword) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__ . '\UserPassword');
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) take care of that
        if (null === $value || '' === $value) {
            return;
        }

        $user = $this->context->getObject();

        if (false === $this->isSame($value, $user)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->setCode(UserPassword::INVALID_PASSWORD_ERROR)
                ->addViolation();
        }
    }

    public function isSame($value, $user): bool
    {
        $encoder = $this->encoderFactory->getEncoder($user);
        $oldPassword = $encoder->encodePassword($value, $user->getSalt());

        return $oldPassword == $user->getPassword();
    }
}
