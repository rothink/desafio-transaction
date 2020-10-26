# Desafio - Transaction

- Clonar repositório
    > 
        git clone https://github.com/rothink/desafio-transaction.git


- Entrar no repositório clonado
    > 
        cd desafio-transaction

- Cria o .env
    > 
        cp back/.env.exemple back/.env

- Cria o storage do laravel 
    > 
        mkdir -p ./back/storage/framework/{sessions,views,cache}

- Permissão do storage do laravel 
    > 
        sudo chmod 777 -R ./back/storage

- Subir os serviços com docker
    > 
        docker-compose up --build -d

- Instalar as dependências do backend
    > 
        docker exec -it back composer install


- Gerar chave do laravel
    >  
        docker exec -it back php artisan key:generate


- Permissão do storage do laravel 
    > 
        docker exec -it back chmod 777 -R storage


- Limpar cache de rotas, config e etc
    > 
        docker exec -it back php artisan optimize:clear
        

- Executar migration e seeds
    > 
        docker exec -it back php artisan migrate:fresh --seed
       
        
- Install passport laravel
    > 
        docker exec -it back php artisan passport:install
        

- Executar os testes 
    >  
        docker exec -it back php artisan test
        
- Swagger API
    >  
        http://localhost:8000/api/documentation
        
        --------------------------------------
        
        Login
        
        email: comum@user.com
        password: 123456

- Aplicação
    >  
        http://localhost:8080
