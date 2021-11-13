[![Contact me on Codementor](https://www.codementor.io/m-badges/dianaarnos/book-session.svg)](https://www.codementor.io/@dianaarnos?refer=badge)

# PHP Paralelo e Distribuído

Exemplos de códigos apresentados durante apresentação.
Implementação de processamento paralelo distribuído utilizando parallel e stream sockets.

Slides da palestra: https://speakerdeck.com/dianaarnos/php-alem-do-sincrono 

### Como usar

A extensão Parallel precisa do PHP ZTS. Nesse repositório, vamos usar uma imagem de Docker que já está com PHP 7.4 ZTS.

Todos os comandos a seguir são executados a partir da raiz do repositório.

Setup para o `hello_world.php` e o exemplo de processamento paralelo:
```shell script
docker-compose up -d
```

Para rodar o script `hello_world.php`:

```shell script
docker-compose exec php php hello_world.php
```

Para rodar o código de processamento paralelo:

```shell script
docker-compose exec php php paralelo/contagem_caracteres.php [workers=4]
```

Para rodar o código de processamento distribuído: 

```shell script
$ cd distribuido
$ docker-compose up
```
