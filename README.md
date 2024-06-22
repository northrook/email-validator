# Email Validator

A wrapper for the [Egulias Email Validator](https://github.com/egulias/email-validator).

> [!CAUTION]
> This package is still in development.
>
> Do **not** use it in production.

Slated features:
- [x] Validate email addresses using [Egulias Email Validator](https://github.com/egulias/email-validator).
- [ ] Domain filtering
- [ ] IP filtering

Filters allow for partial or exact matching against a white or black list of domains and/or IP addresses.

The blacklist can be fed from a centralized source, such as a database or a file.

## Installation
```bash
composer require northrook/email-validator
```

## Usage
```php
use Northrook\EmailValidator;

$validator = new EmailValidator();

$validator->isValid( 'test@example.com' ); // true

$validator->isValid( 'test@example!com' ); // false
```

When the `isValid` method returns `false`, the following properties are available for the failed validation:

```php
$validator->isValid;  // bool 
$validator->warnings; // array of warnings encountered during validation.
$validator->error;    // ?InvalidEmail object if invalid, else `null`.
$validator->reason;   // ?Reason object if invalid, else `null`.
```

## License
[MIT](https://github.com/northrook/email-validator/blob/master/LICENSE)