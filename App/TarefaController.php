<?php
require "App/TarefaModel.php";
require "App/TarefaService.php";
require "App/Conexao.php";

$acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;

if ($acao == 'inserir') {
    $tarefa = new Tarefa();
    $tarefa->__set('tarefa', $_POST['tarefa']);

    $conexao = new Conexao();

    $tarefaService = new TarefaService($conexao, $tarefa);
    $tarefaService->inserir();

    header('Location: nova_tarefa.php?inclusao=1');
} else if ($acao == 'recuperar') {
    $tarefa = new Tarefa();
    $conexao = new Conexao();

    $tarefaService = new TarefaService($conexao, $tarefa);

    $tarefas = $tarefaService->recuperar();
} else if ($acao == 'atualizar') {
    $tarefa = new Tarefa();
    $conexao = new Conexao();

    $tarefa->__set('id', $_POST['id']);
    $tarefa->__set('tarefa', $_POST['tarefa']);

    $tarefaService = new TarefaService($conexao, $tarefa);

    if ($tarefaService->atualizar()) {
        if (isset($_GET['page']) && $_GET['page'] == 'index') {
            header('Location: index.php');
        } else {
            header('Location: todas_tarefas.php');
        }
    }
} else if ($acao == 'remover') {
    $tarefa = new Tarefa();
    $conexao = new Conexao();

    $tarefa->__set('id', $_GET['id']);

    $tarefaService = new TarefaService($conexao, $tarefa);

    $tarefaService->remover();

    if (isset($_GET['page']) && $_GET['page'] == 'index') {
        header('Location: index.php');
    } else {
        header('Location: todas_tarefas.php');
    }
} else if ($acao == 'marcarRealizada') {
    $tarefa = new Tarefa();
    $conexao = new Conexao();

    $tarefa->__set('id', $_GET['id']);
    $tarefa->__set('id_status', 2);

    $tarefaService = new TarefaService($conexao, $tarefa);

    $tarefaService->marcarRealizada();

    if (isset($_GET['page']) && $_GET['page'] == 'index') {
        header('Location: index.php');
    } else {
        header('Location: todas_tarefas.php');
    }
} else if ($acao == 'recuperarTarefasPendentes') {
    $tarefa = new Tarefa();
    $conexao = new Conexao();

    $tarefa->__set('id_status', 1);

    $tarefaService = new TarefaService($conexao, $tarefa);

    $tarefas = $tarefaService->recuperarTarefasPendentes();
}
?>