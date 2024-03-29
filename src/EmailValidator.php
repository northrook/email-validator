<?php

declare(strict_types=1);

namespace Northrook\Core;

use Egulias\EmailValidator\EmailValidator as Validator;
use Egulias\EmailValidator\Result\InvalidEmail;
use Egulias\EmailValidator\Validation\Extra\SpoofCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd ;
use Egulias\EmailValidator\Validation\NoRFCWarningsValidation;


/**
 * An Email Validator
 *
 * @todo Add Domain Filter
 *       Add TLD Filter
 *       Add IP Filter
 *       Add Spam Filter
 *       Add Blacklist
 *       Add Whitelist
 *       Add list API
 *
 *
 * @author  Martin Nielsen <mn@northrook.com>
 *
 * @link    https://github.com/northrook Documentation
 * @todo    Update URL to documentation
 *
 */
final class EmailValidator
{

    private Validator $validator;

    public readonly bool $isValid;
    public readonly array $warnings;
    public readonly ?InvalidEmail $error;

    public function __invoke() : bool{
        return $this->isValid;
    }

    public function __construct(
        public readonly string $email
    ) {

        $this->validator = new Validator();

        $validate = new MultipleValidationWithAnd(
            [
                new NoRFCWarningsValidation(),
                new SpoofCheckValidation(),
            ]
        );

        $this->isValid = $this->validator->isValid(
            $this->email,
            $validate,
        );

        $this->warnings = $this->validator->getWarnings();
        $this->error = $this->validator->getError();
    }

}