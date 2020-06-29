<?php

declare(strict_types=1);

sleep(3); // pequena gambiarra pra garantir que os workers iniciem antes do client rodar

$workersHosts = ['worker1:8001', 'worker2:8002'];
$caminhoArquivo = __DIR__ . "/texto.txt";
$diretorioTemporario = __DIR__ . "/tmp";

function dividirArquivo(string $caminhoArquivo, string $diretorioTemporario, int $quantidade): void
{
    echo PHP_EOL . "O arquivo será dividido em {$quantidade} parte(s), uma para cada worker:" . PHP_EOL;

    $tamanhoArquivo = filesize($caminhoArquivo);
    $tamanhoPedaco = $tamanhoArquivo / $quantidade;
    $handle = fopen($caminhoArquivo, 'rb');

    $i = 1;
    while (!feof($handle) && $i <= $quantidade) {
        $buffer = fread($handle, (int)round($tamanhoPedaco));
        $nomePedacoArquivo = $diretorioTemporario . '/pedaco_' . $i . '.txt';
        $fw = fopen($nomePedacoArquivo, 'wb');
        fwrite($fw, $buffer);
        fclose($fw);
        $i++;

        echo "Arquivo gerado: {$nomePedacoArquivo}" . PHP_EOL;
    }

    fclose($handle);
}

function enviaParaWorkers(string $diretorio, array $workersHosts): int
{
    $futures = [];
    $resultado = 0;

    foreach ($workersHosts as $key => $worker) {
        $key = $key + 1; // pequena gambiarra pra normalizar o nomw do worker

        $runtime = new parallel\Runtime();
        $futures[] = $runtime->run(function () use ($key, $worker, $diretorio) {
            echo "[Thread {$key}] Iniciando conexão com worker{$key}..." . PHP_EOL;
            $client = stream_socket_client("tcp://{$worker}", $errorNum, $errorMsg, 10);

            if ($client == false) {
                throw new \UnexpectedValueException("[Thread {$key}] Falha ao conectar ao worker{$key}: {$errorNum} - {$errorMsg}" . PHP_EOL);
            }

            $arquivo = $diretorio . '/pedaco_' . $key . '.txt';
            echo "[Thread {$key}] Lendo arquivo {$arquivo}..." . PHP_EOL;
            $handle = fopen($arquivo, 'rb');
            $texto = fread($handle, 1048576); //1Mb

            echo "[Thread {$key}] Enviando dados ao worker..." . PHP_EOL;
            fwrite($client, base64_encode($texto));
            $resultado = stream_get_contents($client);
            echo "[Thread {$key}] Resultado recebido!" . PHP_EOL;

            fclose($client);
            echo "[Thread {$key}] Conexão com worker{$key} encerrada." . PHP_EOL;

            return $resultado;
        });
    }

    foreach ($futures as $future) {
        $resultado += $future->value();
    }

    return $resultado;
}

function removeArquivosTemporarios(string $diretorioTemporario)
{
    array_map('unlink',  glob($diretorioTemporario . "/*"));
}

function run(string $caminhoArquivo, $workersHosts, string $diretorioTemporario): void
{
    echo PHP_EOL . "Iniciando client.php" . PHP_EOL;
    echo "Arquivo para contar caracteres: {$caminhoArquivo}" . PHP_EOL;

    dividirArquivo($caminhoArquivo, $diretorioTemporario, count($workersHosts));
    $totalCaracteres = enviaParaWorkers($diretorioTemporario, $workersHosts);
    removeArquivosTemporarios($diretorioTemporario);

    echo PHP_EOL . "O arquivo {$caminhoArquivo} tem {$totalCaracteres} caracteres." . PHP_EOL;
}

run($caminhoArquivo, $workersHosts, $diretorioTemporario);
