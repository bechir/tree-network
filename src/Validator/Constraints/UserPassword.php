<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Constraint for the user password validator.
 *
 * @Annotation
 *
 * @author Bechir Ba <bechiirr71@gmail.com>
 */
class UserPassword extends Constraint
{
    const INVALID_PASSWORD_ERROR = '57cc3ab5-0c3e-13ad-b00f-334bbfe573d';

    public $message = 'L\'ancien mot de passe n\'est pas valide.';
    public $fields = array();

    protected static $errorNames = array(
        self::INVALID_PASSWORD_ERROR => 'INVALID_PASSWORD_ERROR',
    );
}
