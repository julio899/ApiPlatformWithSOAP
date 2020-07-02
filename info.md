# Create a new Symfony Flex project
$ composer create-project symfony/skeleton bookshop-api
# Enter the project folder
$ cd bookshop-api
# Install the API Platform's server component in this skeleton
$ composer req api
Then, create the database and its schema:

$ bin/console doctrine:database:create
$ bin/console doctrine:schema:create
And start the built-in PHP server:

# Built-in PHP server
$ php -S 127.0.0.1:8000 -t public

composer require symfony/maker-bundle --dev
# Add entity, you can also use Symfony MakerBundle
php bin/console make:entity --api-resource

 php bin/console doctrine:schema:update --force
