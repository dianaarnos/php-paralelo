# PHP Paralelo e Distribuído

Exemplo de código apresentado durante apresentação para o PHPPR: https://www.youtube.com/watch?v=sUcVGaENKvc 

Implementação de processamento paralelo distribuído utilizando parallel e stream sockets.

Slides da palestra: --  

### Como usar

A extensão Parallel precisa do PHP ZTS. Nesse repositório, vamos usar uma imagem de Docker que já está com PHP 7.4 ZTS.

Todos os comandos a seguir são executados a partir da raiz do repositório.

Setup:
```shell script
docker-compose up -d
```

Para rodar o script `hello_world.php`:

```shell script
docker-compose exec php php hello_world.php
```

Para rodar o código de processamento paralelo:

```shell script
docker-compose exec php php paralelo/contage_caracteres.php [texto.txt] [workers=4]
```

Para rodar o código de processamento paralelo e distribuído:

**TODO**