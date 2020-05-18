<?php

session_start();
require './Apostador.php';

$apostador = new Apostador();


if ($_REQUEST['action'] == 'login') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $apostador->login($email, $senha);
} elseif ($_SESSION['nome'] and $_GET['action'] == 'novoApostador') {
    $apostador->displayNovoAps();
} elseif ($_SESSION['nome'] and $_GET['action'] == 'apostadores') {
    $apostador->displayAdmin();
} elseif ($_SESSION['nome'] and $_GET['action'] == 'cadastrarNovoAps') {
    $nome = $_POST['nome'];
    $n1 = $_POST['n1'];
    $n2 = $_POST['n2'];
    $n3 = $_POST['n3'];
    $n4 = $_POST['n4'];
    $n5 = $_POST['n5'];
    $n6 = $_POST['n6'];
    $n7 = $_POST['n7'];
    $n8 = $_POST['n8'];
    $n9 = $_POST['n9'];
    $n10 = $_POST['n10'];
    $apostador->novoAps($nome, $n1, $n2, $n3, $n4, $n5, $n6, $n7, $n8, $n9, $n10);
} elseif ($_SESSION['nome'] and $_GET['action'] == 'editar') {
    $id = $_GET['id'];
    $apostador->editarAps($id);
} elseif ($_SESSION['nome'] and $_GET['action'] == 'atualizarAps') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $n1 = $_POST['n1'];
    $n2 = $_POST['n2'];
    $n3 = $_POST['n3'];
    $n4 = $_POST['n4'];
    $n5 = $_POST['n5'];
    $n6 = $_POST['n6'];
    $n7 = $_POST['n7'];
    $n8 = $_POST['n8'];
    $n9 = $_POST['n9'];
    $n10 = $_POST['n10'];
    $apostador->atualizarAps($nome, $n1, $n2, $n3, $n4, $n5, $n6, $n7, $n8, $n9, $n10, $id);
} elseif ($_SESSION['nome'] and $_GET['action'] == 'excluir') {
    $id = $_GET['id'];
    $apostador->excluirAps($id);
} elseif ($_SESSION['nome'] and $_GET['action'] == 'concursos') {
    $concurso = new Concurso();
    $concurso->displayConcAdmin();
} elseif ($_SESSION['nome'] and $_GET['action'] == 'novoConcurso') {
    $concurso = new Concurso();
    $concurso->novoConcAdmin();
} elseif ($_SESSION['nome'] and $_GET['action'] == 'cadNovoConc') {
    $dt = $_POST['data'];
    $nC = $_POST['concurso'];
    $n1 = $_POST['n1'];
    $n2 = $_POST['n2'];
    $n3 = $_POST['n3'];
    $n4 = $_POST['n4'];
    $n5 = $_POST['n5'];
    $concurso = new Concurso();
    $concurso->criarConc($dt, $nC, $n1, $n2, $n3, $n4, $n5);
} elseif ($_SESSION['nome'] and $_GET['action'] == 'editarConc') {
    $id = $_GET['id'];
    $concurso = new Concurso();
    $concurso->editarConc($id);
} elseif ($_SESSION['nome'] and $_GET['action'] == 'salvarUpdateConc') {
    $dt = $_POST['data'];
    $nC = $_POST['concurso'];
    $n1 = $_POST['n1'];
    $n2 = $_POST['n2'];
    $n3 = $_POST['n3'];
    $n4 = $_POST['n4'];
    $n5 = $_POST['n5'];
    $id = $_GET['id'];
    $concurso = new Concurso();
    $concurso->atualizarConc($dt, $nC, $n1, $n2, $n3, $n4, $n5, $id);
} elseif ($_SESSION['nome'] and $_GET['action'] == 'excluirConc') {
    $id = $_GET['id'];
    $concurso = new Concurso();
    $concurso->excluirConc($id);
} elseif ($_SESSION['nome'] and $_GET['action'] == 'excluirTodos') {
    $concurso = new Concurso();
    $concurso->excluirTodosDisplay();
} elseif ($_SESSION['nome'] and $_GET['action'] == 'excluirTodosConc') {
    $concurso = new Concurso();
    $concurso->excluirTodosConc();
} elseif ($_SESSION['nome'] and $_GET['action'] == 'excluirTodosAps') {
    $apostador->excluirTodosAps();
} else {
    unset($_SESSION['nome']);
    echo '<h2>Faça login para acessar<h2>';
    echo "<br><a href='formLogin.html'>Fazer Login<a>";
}