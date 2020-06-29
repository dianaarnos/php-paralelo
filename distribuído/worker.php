<?php

declare(strict_types=1);

$socket = $argv[1] ?: "";

function run(string $socket)
{
    $server = stream_socket_server("tcp://{$socket}", $errorNum, $errorMsg);
    echo "[{$socket}] Aguardando conexões..." . PHP_EOL;

    if ($server === false) {
        throw new \UnexpectedValueException(
            "Não foi possível a conexão com o socket: {$errorNum} - {$errorMsg}" . PHP_EOL
        );
    }

    while ($conn = stream_socket_accept($server)) {
        echo "[{$socket}] Conexão iniciada!" . PHP_EOL;
        $result = strlen(base64_decode(fread($conn, 13421772)));
        fwrite($conn, $result . PHP_EOL);
        fclose($conn);
        echo "[{$socket}] Conexão encerrada!" . PHP_EOL;
    }

    fclose($server);
    echo "[{$socket}] Worker finalizado." . PHP_EOL;
}

echo PHP_EOL . "Iniciando {$socket}" . PHP_EOL;
run($socket);
