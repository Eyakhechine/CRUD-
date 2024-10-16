symfony new my_project --version=6.4 
composer require symfony/maker-bundle --dev 
composer require orm
composer require form validator twig-bundle security-csrf 
php bin/console doctrine:database:create
php bin/console make:entity Product
php bin/console make:crud Product 
php bin/console make:migration
composer require nelmio/cors-bundle 
symfony server:start 
///////////////////////////////////////////
npm install -g @angular/cli 
ng new my_project --no-standalone 
ng generate class models/Product --type=model 
ng generate component components/product-list 
ng generate service services/product  
ng s
