# PHP Paralelo e Distribuído

Exemplo de código apresentado durante apresentação para o PHPPR: https://www.youtube.com/watch?v=sUcVGaENKvc 

Implementação de processamento paralelo distribuído utilizando parallel e stream sockets.

Slides da palestra: --  

### Como usar

A extensão Parallel precisa do PHP ZTS. Nesse repositório, vamos usar uma imagem de Docker que já está com PHP 7.4 ZTS.

Para rodar o script hello_world.php, rode os seguintes comandos na raiz do repositório:

```shell script
$ docker-compose up -d
$ docker-compose exec php php hello_world.php
```