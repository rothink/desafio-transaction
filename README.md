# Desafio - Transaction

- Subir os serviços com docker
    > 
        docker-compose up --build -d


- Gerar chave do laravel
    >  
        docker-compose exec back php artisan key:generate


- Limpar cache de rotas, config e etc
    > 
        docker exec -it back php artisan optimize:clear

- Alterar configurações do banco de dados
    >
        #Dentro do container
        
        > docker-compose exec db bash                          
    
        > mysql -u root -p
        
        #Digite a senha do root
        
        > root
        
        #Dê permissões para o usuário
        
        > GRANT ALL ON laravel.* TO 'root'@'%' IDENTIFIED BY 'root';
        
        > FLUSH PRIVILEGES;
        
        > EXIT;
        
        #Sair do container
        
        > exit;
        

- Executar migration e seeds
    > 
        docker exec -it back php artisan migrate:fresh --seed


- Executar os testes 
    >  
        docker exec -it back php artisan test
        
- Swagger API
    >  
        http://localhost:8000/api/documentation

- Aplicação
    >  
        http://localhost:8080
