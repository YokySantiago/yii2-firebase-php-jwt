Yii2 Auth Firebase JTW Token
============================
Clase de generación, comprobación y obtención de información con token JWT, para la libería firebase / php-jwt

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yokysantiago/yii2-firebase-php-jwt "*"
```

or add

```
"yokysantiago/yii2-firebase-php-jwt": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
try {
    $auth = new AuthJwt();
    $token = $auth->generateToken(['some' => 'info']);
    $auth->checkToken($token);
    $data = $auth->getData($token);
} catch( Exception $e ) {
    \Yii::error($e->getMessage());
}
```