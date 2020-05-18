<?php

require './conexao.php';

class Concurso {

    // FUNÇÃO PARA EXCLUIR CONCURSO
    function excluirConc($id) {
        include 'conexao.php';
        $excluirConc = $conexao->query("delete from concursos where id = '$id'");
        if ($excluirConc) {
            $mensagem = file_get_contents('containerAdmin.html');
            $mensagem = str_replace('{jumbotron}', "Ok, concurso excluído!", $mensagem);
            $mensagem = str_replace('{admin}', $_SESSION['nome'], $mensagem);
            $mensagem = str_replace('{none}', "none", $mensagem);
            $mensagem = str_replace('{body}', "<a class='ml-5' href='admin.php?action=concursos' role='button'><h3>Voltar</h3></a>", $mensagem);
            print $mensagem;
        } else {
            $mensagem = file_get_contents('containerAdmin.html');
            $mensagem = str_replace('{jumbotron}', "Houve algum erro, por favor, volte e tente novamente.", $mensagem);
            $mensagem = str_replace('{admin}', $_SESSION['nome'], $mensagem);
            $mensagem = str_replace('{body}', "<a class='ml-5' href='admin.php?action=novoApostador' role='button'><h3>Voltar</h3></a>", $mensagem);
            print $mensagem;
        }
    }

    // FUNÇÃO PARA PEGAR OS CONCURSOS
    function getConc() {
        include 'conexao.php';

        $sql = $conexao->query("SELECT * FROM concursos");
        $linha = $sql->rowCount();

        if ($linha > 0) {

            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {

                $n1 = intval($row['n1']);
                $n2 = intval($row['n2']);
                $n3 = intval($row['n3']);
                $n4 = intval($row['n4']);
                $n5 = intval($row['n5']);

                $arrayConc[] = array($n1, $n2, $n3, $n4, $n5);
            }
        } else {
            $n1 = 0;
            $n2 = 0;
            $n3 = 0;
            $n4 = 0;
            $n5 = 0;

            $arrayConc[] = array($n1, $n2, $n3, $n4, $n5);
        }

        //JUNTAR AS COLUNAS DO ARRAY DE CONCURSOS
        $a1 = array_column($arrayConc, "0");
        $a2 = array_column($arrayConc, "1");
        $a3 = array_column($arrayConc, "2");
        $a4 = array_column($arrayConc, "3");
        $a5 = array_column($arrayConc, "4");

        //TRANSFORMAR OS ÍNDICES EM UM SÓ ÍNDICE
        $arrayFinal = array_merge($a1, $a2, $a3, $a4, $a5);

        // PEGAR TODOS OS NÚMEROS SEM REPETIÇÕES
        $result = array_unique($arrayFinal);

        return $result;
    }

    //FUNÇÃO PARA MOSTRAR OS CONCURSOS NO MODAL
    function displayConc() {
        include 'conexao.php';
        $sql = $conexao->query("select distinct id,data,concNum,n1,n2,n3,n4,n5 from concursos");
        $linha = $sql->rowCount();
        $cards = "";

        if ($linha > 0) {
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                $card = file_get_contents('cardsConc.html');
                $card = str_replace('{id}', $row['id'], $card);
                $card = str_replace('{data}', $row['data'], $card);
                $card = str_replace('{concNum}', $row['concNum'], $card);
                $card = str_replace('{n1}', $row['n1'], $card);
                $card = str_replace('{n2}', $row['n2'], $card);
                $card = str_replace('{n3}', $row['n3'], $card);
                $card = str_replace('{n4}', $row['n4'], $card);
                $card = str_replace('{n5}', $row['n5'], $card);
                $cards .= $card;
            }
            $display = file_get_contents('containerCards.html');
            $display = str_replace('{concursos}', $cards, $display);
            $display2 = file_get_contents('containerClassificacao.html');
            $display2 = str_replace('{concursos}', $cards, $display2);
            return $display;
            return $display2;
        } else {
            $display = file_get_contents('containerCards.html');
            $display = str_replace('{concursos}', "...", $display);
            $display2 = file_get_contents('containerClassificacao.html');
            $display2 = str_replace('{concursos}', "...", $display2);
            return $display;
            return $display2;
        }
    }

    /////////////////////////////////////////ADMIN///////////////////////////////////

    function displayConcAdmin() {
        include 'conexao.php';

        $query = $conexao->query("select DISTINCT id,data,concNum,n1,n2,n3,n4,n5 from concursos");
        $linha = $query->rowCount();
        $cards = " ";
        if ($linha > 0) {
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $card = file_get_contents('cardsConcAdmin.html');
                $card = str_replace('{editar}', "Editar", $card);
                $card = str_replace('{id}', $row['id'], $card);
                $data = date('d/m/Y', strtotime($row['data']));
                $card = str_replace('{data}', $data, $card);
                $card = str_replace('{concNum}', $row['concNum'], $card);
                $card = str_replace('{n1}', $row['n1'], $card);
                $card = str_replace('{n2}', $row['n2'], $card);
                $card = str_replace('{n3}', $row['n3'], $card);
                $card = str_replace('{n4}', $row['n4'], $card);
                $card = str_replace('{n5}', $row['n5'], $card);
                $cards .= $card;
            }
            $disp = file_get_contents('tableConcursos.html');
            $disp = str_replace('{concursos}', $cards, $disp);
            $display = file_get_contents('containerAdmin.html');
            $display = str_replace('{admin}', $_SESSION['nome'], $display);
            $display = str_replace('{concursos}', "none", $display);
            $display = str_replace('{jumbotron}', "Concursos", $display);
            $display = str_replace('{body}', $disp, $display);
            print $display;
        } else {
            $disp = file_get_contents('tableConcursos.html');
            $disp = str_replace('{concursos}', "...", $disp);
            $display = file_get_contents('containerAdmin.html');
            $display = str_replace('{admin}', $_SESSION['nome'], $display);
            $display = str_replace('{concursos}', "none", $display);
            $display = str_replace('{none}', "none", $display);
            $display = str_replace('{jumbotron}', "Concursos", $display);
            $display = str_replace('{body}', "<h2 class='ml-5 container display-4'>Nenhum Concurso Cadastrado...</h2>", $display);
            print $display;
        }
    }

    //FORM PARA NOVO CONCURSO
    function novoConcAdmin() {
        include 'conexao.php';

        $card = file_get_contents('formNovoConcurso.html');
        $card = str_replace('{action}', "admin.php?action=cadNovoConc", $card);
        $card = str_replace('{excluir}', "none", $card);
        $card = str_replace('{none}', "none", $card);
        $card = str_replace('{botao}', "Cadastrar", $card);
        $display = file_get_contents('containerAdmin.html');
        $display = str_replace('{admin}', $_SESSION['nome'], $display);
        $display = str_replace('{novoConcurso}', "none", $display);
        $display = str_replace('{none}', "none", $display);
        $display = str_replace('{body}', $card, $display);
        $display = str_replace('{jumbotron}', "Novo Concurso", $display);

        print $display;
    }

    // FUNÇÃO PARA CRIAR NOVO CONCURSO
    function criarConc($dt, $nC, $n1, $n2, $n3, $n4, $n5) {
        include 'conexao.php';

        $insereConc = $conexao->query("insert into concursos(id,data,concNum,n1,n2,n3,n4,n5) values (default,'$dt','$nC','$n1','$n2','$n3','$n4','$n5')");
        if ($insereConc) {
            $mensagem = file_get_contents('containerAdmin.html');
            $mensagem = str_replace('{jumbotron}', "Ok, concurso " . $nC . " cadastrado!", $mensagem);
            $mensagem = str_replace('{admin}', $_SESSION['nome'], $mensagem);
            $mensagem = str_replace('{body}', "<a class='ml-5' href='admin.php?action=concursos' role='button'><h3>Voltar</h3></a>", $mensagem);
            print $mensagem;
        } else {
            $mensagem = file_get_contents('containerAdmin.html');
            $mensagem = str_replace('{jumbotron}', "Houve algum erro, por favor, volte e tente novamente.", $mensagem);
            $mensagem = str_replace('{admin}', $_SESSION['nome'], $mensagem);
            $mensagem = str_replace('{body}', "<a class='ml-5' href='admin.php?action=novoConcurso' role='button'><h3>Voltar</h3></a>", $mensagem);
            print $mensagem;
        }
    }

    // FUNÇÃO PARA EDITAR CONCURSO
    function editarConc($id) {
        include 'conexao.php';
        $editar = $conexao->query("select * from concursos where id = '$id'");
        $row = $editar->fetch(PDO::FETCH_ASSOC);
        $display = file_get_contents('formNovoConcurso.html');
        $display = str_replace('{id}', $row['id'], $display);
        $display = str_replace('{none}', "none", $display);
        $display = str_replace('{action}', "admin.php?action=salvarUpdateConc&id=$id", $display);
        $display = str_replace('{data}', $row['data'], $display);
        $display = str_replace('{concurso}', $row['concNum'], $display);
        $display = str_replace('{n1}', $row['n1'], $display);
        $display = str_replace('{n2}', $row['n2'], $display);
        $display = str_replace('{n3}', $row['n3'], $display);
        $display = str_replace('{n4}', $row['n4'], $display);
        $display = str_replace('{n5}', $row['n5'], $display);
        $display = str_replace('{botao}', "Atualizar", $display);

        $container = file_get_contents('containerAdmin.html');
        $container = str_replace('{none}', "none", $container);
        $container = str_replace('{body}', $display, $container);
        $container = str_replace('{admin}', $_SESSION['nome'], $container);
        $container = str_replace('{jumbotron}', "Editar Apostador", $container);
        $container = str_replace('{novoAps}', "none", $container);
        print $container;
    }

    // ATUALIZAR CONCURSO ******************************************
    function atualizarConc($dt, $nC, $n1, $n2, $n3, $n4, $n5, $id) {
        include 'conexao.php';

        $atualizarConc = $conexao->query("UPDATE concursos SET data='$dt', concNum='$nC', n1='$n1',n2='$n2',n3='$n3',n4='$n4',n5='$n5' WHERE id ='$id' ");

        if ($atualizarConc) {
            $mensagem = file_get_contents('containerAdmin.html');
            $mensagem = str_replace('{jumbotron}', "Ok, concurso atualizado!", $mensagem);
            $mensagem = str_replace('{admin}', $_SESSION['nome'], $mensagem);
            $mensagem = str_replace('{none}', "none", $mensagem);
            $mensagem = str_replace('{body}', "<a class='ml-5' href='admin.php?action=concursos' role='button'><h3>Voltar</h3></a>", $mensagem);
            print $mensagem;
        } else {
            $mensagem = file_get_contents('containerAdmin.html');
            $mensagem = str_replace('{jumbotron}', "Houve algum erro, por favor, volte e tente novamente.", $mensagem);
            $mensagem = str_replace('{admin}', $_SESSION['nome'], $mensagem);
            $mensagem = str_replace('{body}', "<a class='ml-5' href='admin.php?action=concursos' role='button'><h3>Voltar</h3></a>", $mensagem);
            print $mensagem;
        }
    }

    // FUNÇÃO PARA DISPLAY EM EXCLUIR TODOS
    function excluirTodosDisplay() {
        include 'conexao.php';

        $display = file_get_contents('containerAdmin.html');
        $display = str_replace('{admin}', $_SESSION['nome'], $display);

        $body = file_get_contents('containerExcluirTodos.html');
        $display = str_replace('{jumbotron}', "Ecluir Todos", $display);
        $display = str_replace('{body}', $body, $display);
        print $display;
    }

    //FUNÇÃO PARA EXCLUIR TODOS OS CONCURSOS
    function excluirTodosConc() {
        include 'conexao.php';
        $excluirTodosConc = $conexao->query("truncate table concursos ");

        if ($excluirTodosConc) {
            $display = file_get_contents('containerAdmin.html');
            $display = str_replace('{admin}', $_SESSION['nome'], $display);
            $display = str_replace('{jumbotron}', "Ecluir Todos", $display);
            $display = str_replace('{body}', "<h2 class='ml-5 display-4  container'>Ok, todos os concursos foram excluídos com sucesso!</h2>", $display);
            print $display;
        } else {
            $display = file_get_contents('containerAdmin.html');
            $display = str_replace('{admin}', $_SESSION['nome'], $display);
            $display = str_replace('{jumbotron}', "Ecluir Todos", $display);
            $display = str_replace('{body}', "<h2 class='ml-5 display-4  container'>Houve algum erro, por favor, volte e tente novamente.</h2>", $display);
            print $display;
        }
    }

}
