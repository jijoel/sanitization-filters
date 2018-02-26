Sanitization Filters
=======================
This is a collection of custom sanitization filters to be used in conjunction with [Waavi/Sanitizer](https://github.com/Waavi/Sanitizer).

Example
----------
Given a data array with the following format:

```php
$data = [
    'first_name'    =>  'john',
    'last_name'     =>  '<strong>DOE</strong>',
    'email'         =>  '  JOHn@DoE.com',
    'birthdate'     =>  '06/25/1980',
    'jsonVar'       =>  '{"name":"value"}',
];
```

We can easily format it using our Sanitizer and the some of Sanitizer's default filters:

```php
use \Waavi\Sanitizer\Sanitizer;

$filters = [
    'first_name'    =>  'trim|escape|capitalize',
    'last_name'     =>  'trim|escape|capitalize',
    'email'         =>  'trim|escape|lowercase',
    'birthdate'     =>  'trim|format_date:m/d/Y, Y-m-d',
    'jsonVar'       =>  'cast:array',
];

$sanitizer  = new Sanitizer($data, $filters);
var_dump($sanitizer->sanitize());
```

Which will yield:

```php
[
    'first_name'    =>  'John',
    'last_name'     =>  'Doe',
    'email'         =>  'john@doe.com',
    'birthdate'     =>  '1980-06-25',
    'jsonVar'       =>  '["name" => "value"]',
];
```

Available Filters
------------------------

Filter     | Description
-----------|------------------------
alpha      | Alphabetic characters only (a-z)
address    | Street Addresses
country    | Capitalize country name (or abbreviation)
date       | Date values
limit      | Trims the input at a given limit
lower      | Converts the given string to all lowercase
money      | Sets the given string to two decimal places
name       | Converts the string to a Proper Name (eg, Foo O'Bar)
number     | Returns the numeric part of the given string
phone      | A US Telephone number
proper     | Converts the given string to Proper (Title) Case
state      | Capitalize state name (or abbreviation)
strip      | Remove some problematic characters from input. These include:  `' ? ; -- / &`
title-case | Converts the given string to Title Case
upper      | Converts the given string to all uppercase
zip        | Converts to a US zip code


Installation
------------------

Install with composer:

    composer require jijoel/sanitization-filters

We also include a Laravel service provider. You can add it to your providers array in config/app.php:

```php
'providers' => [
    ...
    Waavi\Sanitizer\Laravel\SanitizerServiceProvider::class,
    Jijoel\Sanitizer\Laravel\SanitizerServiceProvider::class,
];
```

NOTE: This class extends the Waavi\Sanitizer class. The service provider MUST be loaded after the Waavi service provider, or you will get an exception that the sanitizer class does not exist.


Usage
--------
It's recommended to sanitize your data in a FormRequest object before applying rules. The Waavi/Sanitizer package includes a SanitizesInput trait, which handles this automatically for you.

```php
use Waavi\Sanitizer\Laravel\SanitizesInput;

class MyFormRequest extends FormRequest
{
    use SanitizesInput;

    public function filters()
    {
        return [
            'name' => 'trim|escape|name',
            'email' => 'trim|escape|lower',
        ];
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
        ];
    }
```

Please note that at this time, in order for this to work, the Sanitizer facade must exist.
