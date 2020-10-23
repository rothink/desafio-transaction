# Desafio - Backend

- Criar um arquivo .env & ajustar user e password
    > sudo cp .env.example .env && sudo chmod 777 -R .env
                          
- Rodar as migrations e seeds                           
    >  php artisan migrate && php artisan migrate:refresh --seed
                                                                              
- Gerar a key da aplicação
    > php artisan key:generate                                                             

- Instalar o passport do Laravel                                                   
    > php artisan passport:install

- Rodar o servidor
    > php artisan serve

docker exec -it app php artisan optimize:clear

docker-compose exec app php artisan key:generate

Criar usuario mysql

docker-compose exec db bash

mysql -u root -p

GRANT ALL ON laravel.* TO 'root'@'%' IDENTIFIED BY 'root';

FLUSH PRIVILEGES;

EXIT;

docker-compose exec app php artisan migrate:fresh --seed


