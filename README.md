# tiagohillebrandt/php-parse-link-header
Parse the HTTP Link header and return the values as an array.

## Installation with Composer

```bash
$ composer require tiagohillebrandt/php-parse-link-header
```

## Usage

```php
$headers = [
    'Link' => '<https://api.github.com/organizations/xyz/repos?page=2>; rel="next", <https://api.github.com/organizations/xyz/repos?page=4>; rel="last"',
];

$links = ( new ParseLinkHeader( $headers['Link'] ) )->toArray();

print_r( $links );
```

The above example will output:

```
Array
(
    [next] => Array
        (
            [link] => https://api.github.com/organizations/xyz/repos?page=2
            [page] => 2
        )

    [last] => Array
        (
            [link] => https://api.github.com/organizations/xyz/repos?page=4
            [page] => 4
        )

)
```
