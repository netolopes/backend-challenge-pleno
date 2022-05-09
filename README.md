## Instruções

INSTRUCOES PARA RODAR O PROJETO UBUNTO 20.04

criar o arquivo .env ,apartir do env.example

#url do projeto
http://localhost:8000/front

#rodar e subir os containers docker
docker-compose  up -d


#docker ps (tem q listar algo parecido cm isso)
CONTAINER ID   IMAGE             COMMAND                  CREATED          STATUS          PORTS                                                                                  NAMES
abcedd80f56e   backezoom_nginx   "/docker-entrypoint.…"   9 minutes ago    Up 9 minutes    0.0.0.0:8000->80/tcp, :::8000->80/tcp, 0.0.0.0:4443->443/tcp, :::4443->443/tcp         appNginx
f20a91b87e8e   backezoom_api     "docker-php-entrypoi…"   10 minutes ago   Up 9 minutes    0.0.0.0:9000->9000/tcp, :::9000->9000/tcp, 0.0.0.0:9003->9003/tcp, :::9003->9003/tcp   appApi
0c45ff68b7d5   backezoom_db      "docker-entrypoint.s…"   10 minutes ago   Up 22 seconds   0.0.0.0:33066->3306/tcp, :::33066->3306/tcp                                            appDb

#*** OBS!!:Caso nao apareca todos , executar novamente (docker-compose up -d , ou docker-compose build).

#Entrar no container docker
docker exec -it appApi bash   (bin/sh ou bin/bash)

#Dentro do container, executar os comandos abaixo
composer install

php artisan migrate  (gerar as tabelas no banco)

#OBS:Ao executar "php artisan migrate" ,caso ocorra esse erro abaixo , sair do container e executar novamente "docker-compose  up -d",pois provavelmente o container do banco nao startou!, ai depois entre novamente no container
e execute os outros comandos:

 Illuminate\Database\QueryException 
  SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo failed: Temporary failure in name resolution (SQL: select * from information_schema.tables where table_schema = db_ezoom and table_name = migrations and table_type = 'BASE TABLE')
  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:712


#rodar seeds (gerar dados nas tabelas)
php artisan db:seed

## Imagens
<p align="center"><img src="ezomm1.png" width="400"></p>



