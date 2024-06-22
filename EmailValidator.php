<?php

declare( strict_types = 1 );

namespace Northrook;

use Egulias\EmailValidator\EmailValidator as Validator;
use Egulias\EmailValidator\Result\InvalidEmail;
use Egulias\EmailValidator\Result\Reason\Reason;
use Egulias\EmailValidator\Validation\Extra\SpoofCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\NoRFCWarningsValidation;
use Northrook\Core\Trait\PropertyAccessor;


/**
 * An Email Validator
 *
 * @property bool          $isValid
 * @property array         $warnings
 * @property ?InvalidEmail $error
 * @property ?Reason       $reason
 *
 * @author  Martin Nielsen <mn@northrook.com>
 *
 * @link    https://github.com/northrook Documentation
 * @todo    Update URL to documentation
 *
 */
final class EmailValidator
{
    use PropertyAccessor;

    private readonly Validator                 $validator;
    private readonly MultipleValidationWithAnd $validate;

    private bool          $isValid;
    private array         $warnings;
    private ?InvalidEmail $error;
    private ?Reason       $reason;

    public function __construct() {
        $this->validator = new Validator();
        $this->validate  = new MultipleValidationWithAnd(
            [
                new NoRFCWarningsValidation(),
                new SpoofCheckValidation(),
            ],
        );
    }

    public function __get( string $property ) : mixed {
        return match ( $property ) {
            'isValid'  => $this->isValid,
            'warnings' => $this->warnings,
            'error'    => $this->error,
            'reason'   => $this->reason,
            default    => null,
        };
    }

    public static function validate( string $email ) : bool {
        return ( new self() )->isValid( $email );
    }

    public function isValid( string $email ) : bool {

        $this->isValid = $this->validator->isValid(
            $email,
            $this->validate,
        );

        $this->warnings = $this->validator->getWarnings();
        $this->error    = $this->validator->getError();
        $this->reason   = $this->error?->reason();

        return $this->isValid;
    }
}