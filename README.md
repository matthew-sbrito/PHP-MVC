# PHP MVC (DESIGN PATTERN)

  
This repository is intended to help you start a PHP project!

### Download Repository:

`git clone https://github.com/matthew-sbrito/PHP-MVC.git`

### Download Composer for linux:

~~~zsh
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
    php composer-setup.php
    php -r "unlink('composer-setup.php');"

    sudo mv composer.phar /usr/local/bin/composer
~~~

## Installing composer on the project

Composer.json and composer.lock will be loaded!

`composer install`

## To change namespace

Change the namespace ("App\\") and the folder ("App/").

~~~json
    {
    "name":"project/model",
    "description": "Design pattern MVC for future PHP projects!",
    "autoload": {
        "psr-4": {
            "App\\": "App/"
        }
    }
}
~~~
Now 

`composer dump`
# References

    https://www.youtube.com/watch?v=7fxguLAebl4
    https://getcomposer.org/download/ 
