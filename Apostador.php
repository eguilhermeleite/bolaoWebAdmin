<?php

require './conexao.php';
require_once './Concurso.php';

class Apostador {

// PEGAR TODOS OS APOSTADORES E ATUALIZAR OS PONTOS ************************************
    function getAps() {
        include 'conexao.php';
        $con = new Concurso();

        $sql = $conexao->query("SELECT * FROM apostadores");
        $linha = $sql->rowCount();

        if ($linha > 0) {

            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                $id = $row['id'];
                $n1 = intval($row['n1']);
                $n2 = intval($row['n2']);
                $n3 = intval($row['n3']);
                $n4 = intval($row['n4']);
                $n5 = intval($row['n5']);
                $n6 = intval($row['n6']);
                $n7 = intval($row['n7']);
                $n8 = intval($row['n8']);
                $n9 = intval($row['n9']);
                $n10 = intval($row['n10']);

// MONTA UM ARRAY COM OS NÚMEROS DOS APOSTADORES E ÍNDICE = AO ID DE CADA APOSTADOR
                $arrayAps[$id] = array($n1, $n2, $n3, $n4, $n5, $n6, $n7, $n8, $n9, $n10);

// COMPARA O ARRAY DOS APOSTADORES COM O ARRAY DOS CONCURSOS
                $comparar = array_intersect($con->getConc(), $arrayAps[$id]);

// CONTA QUANTOS RESULTADOS SEMELHANTES ENTRE OS DOIS ARRAYS
                $conte = count($comparar);


// ATUALIZA A TABELA APOSTADORES COM O TOTAL DE ACERTOS
                $atualizar = $conexao->query("Update apostadores set total = '$conte'  where id = '$id'");
            }
        } else {
            $id = 0;
            $n1 = 0;
            $n2 = 0;
            $n3 = 0;
            $n4 = 0;
            $n5 = 0;
            $n6 = 0;
            $n7 = 0;
            $n8 = 0;
            $n9 = 0;
            $n10 = 0;

            $arrayAps[$id] = array($n1, $n2, $n3, $n4, $n5, $n6, $n7, $n8, $n9, $n10);
        }
    }

// MOSTRAR OS APOSTADORES**********************************
    function display() {
        include 'conexao.php';
        $con = new Concurso();

        $concQuery = $conexao->query("select distinct id,data,concNum,n1,n2,n3,n4,n5 from concursos");
        $rowConc = $concQuery->rowCount();
        $cards2 = "";

        $pesquisa = $conexao->query("select distinct id,nome,n1,n2,n3,n4,n5,n6,n7,n8,n9,n10,total from apostadores order by total desc");
        $linha = $pesquisa->rowCount();
        $cards = '';

        if ($linha > 0) {

            if ($rowConc > 0) {
                while ($row = $concQuery->fetch(PDO::FETCH_ASSOC)) {
                    $data = date('d/m/Y', strtotime($row['data']));
                    $card = file_get_contents('cardsConc.html');
                    $card = str_replace('{id}', $row['id'], $card);
                    $card = str_replace('{data}', $data, $card);
                    $card = str_replace('{concNum}', $row['concNum'], $card);
                    $card = str_replace('{n1}', $row['n1'], $card);
                    $card = str_replace('{n2}', $row['n2'], $card);
                    $card = str_replace('{n3}', $row['n3'], $card);
                    $card = str_replace('{n4}', $row['n4'], $card);
                    $card = str_replace('{n5}', $row['n5'], $card);
                    $cards2 .= $card;
                }
            }

            while ($row3 = $pesquisa->fetch(PDO::FETCH_ASSOC)) {
                $id = $row3['id'];
                $card = file_get_contents('cards.html');
                $card = str_replace('{id}', $row3['id'], $card);
                $card = str_replace('{nome}', strtoupper($row3['nome']), $card);
                $card = str_replace('{n1}', $row3['n1'], $card);
                $card = str_replace('{n2}', $row3['n2'], $card);
                $card = str_replace('{n3}', $row3['n3'], $card);
                $card = str_replace('{n4}', $row3['n4'], $card);
                $card = str_replace('{n5}', $row3['n5'], $card);
                $card = str_replace('{n6}', $row3['n6'], $card);
                $card = str_replace('{n7}', $row3['n7'], $card);
                $card = str_replace('{n8}', $row3['n8'], $card);
                $card = str_replace('{n9}', $row3['n9'], $card);
                $card = str_replace('{n10}', $row3['n10'], $card);
                $card = str_replace('{total}', $row3['total'], $card);


                if (in_array($row3['n1'], $con->getConc())) {
                    $card = str_replace('{bg1}', "bg-success text-light", $card);
                }
                if (in_array($row3['n2'], $con->getConc())) {
                    $card = str_replace('{bg2}', "bg-success text-light", $card);
                }
                if (in_array($row3['n3'], $con->getConc())) {
                    $card = str_replace('{bg3}', "bg-success text-light", $card);
                }
                if (in_array($row3['n4'], $con->getConc())) {
                    $card = str_replace('{bg4}', "bg-success text-light", $card);
                }
                if (in_array($row3['n5'], $con->getConc())) {
                    $card = str_replace('{bg5}', "bg-success text-light", $card);
                }
                if (in_array($row3['n6'], $con->getConc())) {
                    $card = str_replace('{bg6}', "bg-success text-light", $card);
                }
                if (in_array($row3['n7'], $con->getConc())) {
                    $card = str_replace('{bg7}', "bg-success text-light", $card);
                }
                if (in_array($row3['n8'], $con->getConc())) {
                    $card = str_replace('{bg8}', "bg-success text-light", $card);
                }
                if (in_array($row3['n9'], $con->getConc())) {
                    $card = str_replace('{bg9}', "bg-success text-light", $card);
                }
                if (in_array($row3['n10'], $con->getConc())) {
                    $card = str_replace('{bg10}', "bg-success text-light", $card);
                }

                $cards .= $card;
            }

            $display = file_get_contents('containerCards.html');
            $display = str_replace('{jumbotron}', "Apostadores", $display);
            $display = str_replace('{cards}', $cards, $display);
            $display = str_replace('{concursos}', $cards2, $display);
            print $display;
        } else {
            $display = file_get_contents('containerCards.html');
            $display = str_replace('{jumbotron}', "Apostadores", display);
            $display = str_replace('{cards}', "<br><h2>Nenhum Apostador Cadastrado...</h2><br>", $display);
            print $display;
        }
    }

// FUNÇÃO PARA PROCURAR APOSTADOR*********************
    function procurarAps($nome) {
        include'conexao.php';
        $con = new Concurso();
        $pesquisa = $conexao->query("select * from apostadores where nome like '$nome%'");
        $linha = $pesquisa->rowCount();
        $concQuery = $conexao->query("select * from concursos");
        $rowConc = $concQuery->fetch(PDO::FETCH_ASSOC);
        $cards = '';

//QUERY PARA BUSCAR OS CONCURSOS
        $concQuery = $conexao->query("select distinct data,concNum,n1,n2,n3,n4,n5 from concursos");
        $rowConc = $concQuery->rowCount();
        $cards2 = "";
/////////////////////////////////

        if ($linha > 0) {

// MOSTRAR OS CONCURSOS
            if ($rowConc > 0) {
                while ($row = $concQuery->fetch(PDO::FETCH_ASSOC)) {
                    $data = date('d/m/Y', strtotime($row['data']));
                    $card = file_get_contents('cardsConc.html');
                    $card = str_replace('{data}', $data, $card);
                    $card = str_replace('{concNum}', $row['concNum'], $card);
                    $card = str_replace('{n1}', $row['n1'], $card);
                    $card = str_replace('{n2}', $row['n2'], $card);
                    $card = str_replace('{n3}', $row['n3'], $card);
                    $card = str_replace('{n4}', $row['n4'], $card);
                    $card = str_replace('{n5}', $row['n5'], $card);
                    $cards2 .= $card;
                }
            }


            while ($row3 = $pesquisa->fetch(PDO::FETCH_ASSOC)) {
                $id = $row3['id'];
                $card = file_get_contents('cards.html');
                $card = str_replace('{nome}', strtoupper($row3['nome']), $card);
                $card = str_replace('{n1}', $row3['n1'], $card);
                $card = str_replace('{n2}', $row3['n2'], $card);
                $card = str_replace('{n3}', $row3['n3'], $card);
                $card = str_replace('{n4}', $row3['n4'], $card);
                $card = str_replace('{n5}', $row3['n5'], $card);
                $card = str_replace('{n6}', $row3['n6'], $card);
                $card = str_replace('{n7}', $row3['n7'], $card);
                $card = str_replace('{n8}', $row3['n8'], $card);
                $card = str_replace('{n9}', $row3['n9'], $card);
                $card = str_replace('{n10}', $row3['n10'], $card);


                if (in_array($row3['n1'], $con->getConc())) {
                    $card = str_replace('{bg1}', "bg-success text-light", $card);
                }
                if (in_array($row3['n2'], $con->getConc())) {
                    $card = str_replace('{bg2}', "bg-success text-light", $card);
                }
                if (in_array($row3['n3'], $con->getConc())) {
                    $card = str_replace('{bg3}', "bg-success text-light", $card);
                }
                if (in_array($row3['n4'], $con->getConc())) {
                    $card = str_replace('{bg4}', "bg-success text-light", $card);
                }
                if (in_array($row3['n5'], $con->getConc())) {
                    $card = str_replace('{bg5}', "bg-success text-light", $card);
                }
                if (in_array($row3['n6'], $con->getConc())) {
                    $card = str_replace('{bg6}', "bg-success text-light", $card);
                }
                if (in_array($row3['n7'], $con->getConc())) {
                    $card = str_replace('{bg7}', "bg-success text-light", $card);
                }
                if (in_array($row3['n8'], $con->getConc())) {
                    $card = str_replace('{bg8}', "bg-success text-light", $card);
                }
                if (in_array($row3['n9'], $con->getConc())) {
                    $card = str_replace('{bg9}', "bg-success text-light", $card);
                }
                if (in_array($row3['n10'], $con->getConc())) {
                    $card = str_replace('{bg10}', "bg-success text-light", $card);
                }

                $cards .= $card;
            }

            $display = file_get_contents('containerCards.html');
            $display = str_replace('{jumbotron}', "Pesquisando Apostadores...", $display);
            $display = str_replace('{cards}', $cards, $display);
            $display = str_replace('{concursos}', $cards2, $display); // MOSTRAR OS CONCURSOS NO MODAL
            print $display;
        } else {

            $display = file_get_contents('containerCards.html');
            $display = str_replace('{jumbotron}', "Pesquisando Apostadores...", $display);
            $display = str_replace('{cards}', "<h2>Sem resultados para esta pesquisa</h2>", $display);
            print $display;
        }
    }

// FUNÇÃO MOSTRA A CLASSIFICAÇÃO (DEVE SER UTILIZADA COM A FUNÇÃO GETAPS)
    function clas() {
        include'conexao.php';
        $pesquisa = $conexao->query("select * from apostadores order by total desc");
        $linha = $pesquisa->rowCount();
        $cards = '';
        $i = 1;

        $concQuery = $conexao->query("select * from concursos");
        $rowConc = $concQuery->rowCount();
        $cards = '';
        $cards2 = '';


        if ($linha > 0) {

            if ($rowConc > 0) {
                while ($row = $concQuery->fetch(PDO::FETCH_ASSOC)) {
                    $data = date('d/m/Y', strtotime($row['data']));
                    $card = file_get_contents('cardsConc.html');
                    $card = str_replace('{id}', $row['id'], $card);
                    $card = str_replace('{data}', $data, $card);
                    $card = str_replace('{concNum}', $row['concNum'], $card);
                    $card = str_replace('{n1}', $row['n1'], $card);
                    $card = str_replace('{n2}', $row['n2'], $card);
                    $card = str_replace('{n3}', $row['n3'], $card);
                    $card = str_replace('{n4}', $row['n4'], $card);
                    $card = str_replace('{n5}', $row['n5'], $card);
                    $cards2 .= $card;
                }
            }

            while ($row = $pesquisa->fetch(PDO::FETCH_ASSOC)) {
                $card = file_get_contents('cardsClassificacao.html');
                $card = str_replace('{posicao}', $i . "°", $card);
                $card = str_replace('{nome}', strtoupper($row['nome']), $card);
                $card = str_replace('{total}', $row['total'], $card);
                $i++;
                $cards .= $card;
            }
            $display = file_get_contents('containerClassificacao.html');
            $display = str_replace('{jumbotron}', "Classificação", $display);
            $display = str_replace('{cards}', $cards, $display);
            $display = str_replace('{concursos}', $cards2, $display);
            print $display;
        } else {
            $display = file_get_contents('containerClassificacao.html');
            $display = str_replace('{jumbotron}', "Classificação", $display);
            $display = str_replace('{cards}', "<h2>Sem resultados para esta pesquisa</h2>", $display);
            print $display;
        }
    }

// FUNÇÃO PARA PROCURAR CLASSIFICAÇÃO***********************************
    function procurarApsClas($nomeClas) {
        require './conexao.php';
        $pesquisa = $conexao->query("select * from apostadores where nome like '$nomeClas%'");
        $linha = $pesquisa->rowCount();
        $cards = '';

        if ($linha > 0) {
            $row = $pesquisa->fetch(PDO::FETCH_ASSOC);
            $card = file_get_contents('cardsClassificacao.html');
            $card = str_replace('{posicao}', " ", $card);
            $card = str_replace('{none}', "none", $card);
            $card = str_replace('{nome}', strtoupper($row['nome']), $card);
            $card = str_replace('{total}', $row['total'], $card);

            $cards .= $card;

            $display = file_get_contents('containerClassificacao.html');
            $display = str_replace('{jumbotron}', "Pesquisando Pontuação...", $display);
            $display = str_replace('{none}', "none", $display);
            $display = str_replace('{cards}', $cards, $display);
            print $display;
        } else {
            $display = file_get_contents('containerClassificacao.html');
            $display = str_replace('{jumbotron}', "Pesquisando Pontuação...", $display);
            $display = str_replace('{cards}', "<h2>Sem resultados para esta pesquisa</h2>", $display);
            print $display;
        }
    }

///////////////////////////////////ADMIN////////////////////////////////////////////////////////////////////
    // NOVO APOSTADOR *******************************************
    function novoAps($nome, $n1, $n2, $n3, $n4, $n5, $n6, $n7, $n8, $n9, $n10) {
        include 'conexao.php';

        $novoAps = $conexao->query("insert into apostadores(nome, n1, n2, n3, n4, n5, n6, n7, n8, n9,n10) values('$nome','$n1','$n2','$n3','$n4','$n5','$n6','$n7','$n8','$n9','$n10')");

        if ($novoAps) {
            $mensagem = file_get_contents('containerAdmin.html');
            $mensagem = str_replace('{none}', "none", $mensagem);
            $mensagem = str_replace('{jumbotron}', "Ok, apostador" . strtoupper($nome) . " cadastrado!", $mensagem);
            $mensagem = str_replace('{admin}', $_SESSION['nome'], $mensagem);
            $mensagem = str_replace('{body}', "<a class='ml-5' href='admin.php?action=novoApostador' role='button'><h3>Voltar</h3></a>", $mensagem);
            print $mensagem;
        } else {
            $mensagem = file_get_contents('containerAdmin.html');
            $mensagem = str_replace('{jumbotron}', "Houve algum erro, por favor, volte e tente novamente.", $mensagem);
            $mensagem = str_replace('{admin}', $_SESSION['nome'], $mensagem);
            $mensagem = str_replace('{body}', "<a class='ml-5' href='admin.php?action=novoApostador' role='button'><h3>Voltar</h3></a>", $mensagem);
            print $mensagem;
        }
    }

// MOSTRAR OS APOSTADORES PARA O ADMIN**********************************
    function displayAdmin() {
        include 'conexao.php';

        $pesquisa = $conexao->query("select * from apostadores order by nome asc");
        $linha = $pesquisa->rowCount();
        $cards = '';

        if ($linha > 0) {


            while ($row3 = $pesquisa->fetch(PDO::FETCH_ASSOC)) {
                $id = $row3['id'];
                $card = file_get_contents('cardsAdmin.html');
                $card = str_replace('{id}', $row3['id'], $card);
                $card = str_replace('{nome}', strtoupper($row3['nome']), $card);
                $card = str_replace('{editar}', "Editar", $card);

                $cards .= $card;
            }
            $table = file_get_contents('tableAps.html');
            $table = str_replace('{cards}', $cards, $table);
            $display = file_get_contents('containerAdmin.html');
            $display = str_replace('{apostadores}', 'none', $display);
            $display = str_replace('{jumbotron}', "Apostadores", $display);
            $display = str_replace('{body}', $table, $display);
            $display = str_replace('{admin}', $_SESSION['nome'], $display);
            print $display;
        } else {

            $display = file_get_contents('containerAdmin.html');
            $display = str_replace('{apostadores}', 'none', $display);
            $display = str_replace('{jumbotron}', "Edição", $display);
            $display = str_replace('{none}', "none", $display);
            $display = str_replace('{body}', "<br><h2 class='ml-5 container display-4'>Nenhum Apostador Cadastrado...</h2><br>", $display);
            $display = str_replace('{admin}', $_SESSION['nome'], $display);
            print $display;
        }
    }

    // PROCURAR APOSTADOR ADMIN *****************************
    function displayProcAdmin($n) {
        include 'conexao.php';

        $pesquisa = $conexao->query("select id,nome from apostadores where nome like '$n%'");
        $linha = $pesquisa->rowCount();
        $cards = '';

        if ($linha > 0) {
            while ($row3 = $pesquisa->fetch(PDO::FETCH_ASSOC)) {
                $id = $row3['id'];
                $card = file_get_contents('cardsAdmin.html');
                $card = str_replace('{id}', $row3['id'], $card);
                $card = str_replace('{nome}', strtoupper($row3['nome']), $card);
                $card = str_replace('{editar}', "Editar", $card);

                $cards .= $card;
            }
            $table = file_get_contents('tableAps.html');
            $table = str_replace('{cards}', $cards, $table);
            $display = file_get_contents('containerAdmin.html');
            $display = str_replace('{apostadores}', 'none', $display);
            $display = str_replace('{jumbotron}', "Apostadores", $display);
            $display = str_replace('{body}', $table, $display);
            $display = str_replace('{admin}', $_SESSION['nome'], $display);
            print $display;
        } else {

            $display = file_get_contents('containerAdmin.html');
            $display = str_replace('{apostadores}', 'none', $display);
            $display = str_replace('{jumbotron}', "Edição", $display);
            $display = str_replace('{none}', "none", $display);
            $display = str_replace('{body}', "<br><h2 class='ml-5'>Nenhum Apostador Cadastrado...</h2><br>", $display);
            $display = str_replace('{admin}', $_SESSION['nome'], $display);
            print $display;
        }
    }

// FUNÇÃO PARA LOGIN
    function login($email, $senha) {

        include 'conexao.php';
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $pesquisa = $conexao->query("Select * from administrador where email ='$email'and senha ='$senha'");
        $linha = $pesquisa->rowCount();
        $row = $pesquisa->fetch(PDO::FETCH_ASSOC);

        if ($linha == 1) {

            $_SESSION['nome'] = $row['nome'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['senha'] = $row['senha'];
            $_SESSION['login'] = TRUE;
            $this->displayAdmin();
        } else {
            $_SESSION['login'] = FALSE;
            echo '<h1>Emai e/ou senha incorreta(s)</h1>';
            echo "<br><div align=''><a  href='formLogin.html'>Fazer Login</a></div>";
        }
    }

// FUNÇÃO PARA NOVO APOSTADOR
    function displayNovoAps() {
        $display = file_get_contents('containerAdmin.html');
        $form = file_get_contents('formApostador.html');
        $display = str_replace('{body}', $form, $display);
        $display = str_replace('{none}', "none", $display);
        $display = str_replace('{admin}', $_SESSION['nome'], $display);
        $display = str_replace('{jumbotron}', "Novo Apostador", $display);
        $display = str_replace('{novoAps}', "none", $display);
        $display = str_replace('{nome}', " ", $display);
        print $display;
    }

    // ATUALIZAR APOSTADOR ******************************************
    function atualizarAps($nome, $n1, $n2, $n3, $n4, $n5, $n6, $n7, $n8, $n9, $n10, $id) {
        include 'conexao.php';
        $atualizarAps = $conexao->query("update apostadores set  nome = '$nome', n1 = '$n1', n2='$n2', n3='$n3', n4='$n4', n5='$n5', n6='$n6', n7='$n7', n8='$n8', n9='$n9', n10='$n10' where id ='$id'");
        if ($atualizarAps) {
            $mensagem = file_get_contents('containerAdmin.html');
            $mensagem = str_replace('{jumbotron}', "Ok, apostador" . strtoupper($nome) . " atualizado!", $mensagem);
            $mensagem = str_replace('{admin}', $_SESSION['nome'], $mensagem);
            $mensagem = str_replace('{none}', "none", $mensagem);
            $mensagem = str_replace('{body}', "<a class='ml-5' href='admin.php?action=novoApostador' role='button'><h3>Voltar</h3></a>", $mensagem);
            print $mensagem;
        } else {
            $mensagem = file_get_contents('containerAdmin.html');
            $mensagem = str_replace('{jumbotron}', "Houve algum erro, por favor, volte e tente novamente.", $mensagem);
            $mensagem = str_replace('{admin}', $_SESSION['nome'], $mensagem);
            $mensagem = str_replace('{body}', "<a class='ml-5' href='admin.php?action=novoApostador' role='button'><h3>Voltar</h3></a>", $mensagem);
            print $mensagem;
        }
    }

    //EDITAR APOSTADOR *****************************************
    function editarAps($id) {
        include 'conexao.php';
        $editar = $conexao->query("select * from apostadores where id = '$id'");
        $row = $editar->fetch(PDO::FETCH_ASSOC);
        $display = file_get_contents('containerAdmin.html');
        $display = str_replace('{none}', "none", $display);
        $form = file_get_contents('formEditAps.html');
        $form = str_replace('{id}', $row['id'], $form);
        $form = str_replace('{nome}', $row['nome'], $form);
        $form = str_replace('{n1}', $row['n1'], $form);
        $form = str_replace('{n2}', $row['n2'], $form);
        $form = str_replace('{n3}', $row['n3'], $form);
        $form = str_replace('{n4}', $row['n4'], $form);
        $form = str_replace('{n5}', $row['n5'], $form);
        $form = str_replace('{n6}', $row['n6'], $form);
        $form = str_replace('{n7}', $row['n7'], $form);
        $form = str_replace('{n8}', $row['n8'], $form);
        $form = str_replace('{n9}', $row['n9'], $form);
        $form = str_replace('{n10}', $row['n10'], $form);
        $form = str_replace('{cadastrar}', "none", $form);
        $display = str_replace('{body}', $form, $display);
        $display = str_replace('{admin}', $_SESSION['nome'], $display);
        $display = str_replace('{jumbotron}', "Editar Apostador", $display);
        $display = str_replace('{novoAps}', "none", $display);
        print $display;
    }

// EXCLUIR APOSTADOR *****************************************
    function excluirAps($id) {
        include 'conexao.php';
        $excluirAps = $conexao->query("delete from apostadores where id = '$id'");

        if ($excluirAps) {
            $mensagem = file_get_contents('containerAdmin.html');
            $mensagem = str_replace('{none}', "none", $mensagem);
            $mensagem = str_replace('{jumbotron}', "Ok, apostador excluído!", $mensagem);
            $mensagem = str_replace('{admin}', $_SESSION['nome'], $mensagem);
            $mensagem = str_replace('{body}', "<a class='ml-5' href='admin.php?action=apostadores' role='button'><h3>Voltar</h3></a>", $mensagem);
            print $mensagem;
        } else {
            $mensagem = file_get_contents('containerAdmin.html');
            $mensagem = str_replace('{jumbotron}', "Houve algum erro, por favor, volte e tente novamente.", $mensagem);
            $mensagem = str_replace('{admin}', $_SESSION['nome'], $mensagem);
            $mensagem = str_replace('{body}', "<a class='ml-5' href='admin.php?action=novoApostador' role='button'><h3>Voltar</h3></a>", $mensagem);
            print $mensagem;
        }
    }

// EXCLUIR TODOS OS APOSTADORES *********************************
    function excluirTodosAps() {
        include 'conexao.php';
        $excluirTodosAps = $conexao->query("truncate table apostadores ");
        if ($excluirTodosAps) {
            $display = file_get_contents('containerAdmin.html');
            $display = str_replace('{admin}', $_SESSION['nome'], $display);
            $display = str_replace('{jumbotron}', "Ecluir Todos", $display);
            $display = str_replace('{body}', "<h2 class='ml-5 display-4  container'>Ok, todos os apostadores foram excluídos com sucesso!</h2>", $display);
            print $display;
        } else {
            $display = file_get_contents('containerAdmin.html');
            $display = str_replace('{admin}', $_SESSION['nome'], $display);
            $display = str_replace('{jumbotron}', "Ecluir Todos", $display);
            $display = str_replace('{body}', "<h2 class='ml-5 display-4  container'>Houve algum erro, por favor, volte e tente novamente.</h2>", $display);
            print $display;

            echo "Houve algum erro, por favor, volte e tente novamente.";
        }
    }

}

// fim da classe apostador


