# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/thotam/thotam-permission.svg?style=flat-square)](https://packagist.org/packages/thotam/thotam-permission)
[![Build Status](https://img.shields.io/travis/thotam/thotam-permission/master.svg?style=flat-square)](https://travis-ci.org/thotam/thotam-permission)
[![Quality Score](https://img.shields.io/scrutinizer/g/thotam/thotam-permission.svg?style=flat-square)](https://scrutinizer-ci.com/g/thotam/thotam-permission)
[![Total Downloads](https://img.shields.io/packagist/dt/thotam/thotam-permission.svg?style=flat-square)](https://packagist.org/packages/thotam/thotam-permission)

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what PSRs you support to avoid any confusion with users and contributors.

## Installation

You can install the package via composer:

```bash
composer require thotam/thotam-permission
```

## Usage

#### Public ThotamPermissionServiceProvider

```php
php artisan vendor:publish --provider="Thotam\ThotamPermission\ThotamPermissionServiceProvider"
```

#### Clear your config cache with either of these commands

```php
 php artisan optimize:clear
 # or
 php artisan config:clear
```

#### Edit Thotam\ThotamHr\Models\HR Models:

```php
implements Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
add Traits Illuminate\Foundation\Auth\Access\Authorizable;
add Traits Spatie\Permission\Traits\HasRoles;
add protected $guard_name = 'web';
```

#### Next, you should migrate your database:

```php
php artisan migrate
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email thanhtamtqno1@gmail.com instead of using the issue tracker.

## Credits

-   [thotam](https://github.com/thotam)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
