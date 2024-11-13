<?php
require_once 'config/config.php';

if (isset($_SESSION['user_token'])) {
    $sql = "SELECT user_type FROM users WHERE token ='{$_SESSION['user_token']}'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $userinfo = mysqli_fetch_assoc($result);
        
        if ($userinfo['user_type'] == 'admin') {
            header("Location: public/admin_dashboard.php");
        } else {
            header("Location: public/user_dashboard.php");
        }
        
        exit(); 
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Sobre a Comissão Própria de Avaliação - UPE</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        html, body {
    height: 100%;
    margin: 0;
    font-family: 'Roboto', sans-serif;
}
body {
    display: flex;
    background-color: #f7f8fa;
}

h2 {
    font-size: 2.5rem;
    font-weight: bold;
    color: #343a40;
    margin-top: 40px; /* Espaço acima do título */
    margin-bottom: 30px; /* Espaço abaixo do título */
    text-align: center;
}

.sidebar {
    width: 250px;
    height: 100vh;
    background-color: #343a40;
    padding: 20px;
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
    color: white;
    position: fixed;
    transition: width 0.3s, transform 0.3s;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.sidebar.hidden-mobile {
    transform: translateX(-100%);
}
.sidebar.minimized {
    width: 80px;
}
.sidebar h2 {
    text-align: center;
    margin-bottom: 30px;
    transition: opacity 0.3s;
}
.sidebar.minimized h2 {
    opacity: 0;
}
.sidebar a {
    display: flex;
    align-items: center;
    padding: 15px;
    color: #ddd;
    text-decoration: none;
    border-radius: 5px;
    margin-bottom: 10px;
    transition: background-color 0.3s;
    width: 100%;
    justify-content: flex-start;
}
.sidebar a:hover {
    background-color: #495057;
    color: white;
}
.sidebar a.active {
    background-color: #495057;
    color: white;
}
.sidebar a i {
    margin-right: 10px;
}
.sidebar.minimized a {
    justify-content: center;
}
.sidebar.minimized a i {
    margin-right: 0;
}
.sidebar.minimized a span {
    display: none;
}
.sidebar .btn-danger {
    width: 100%;
    margin-top: auto;
}
.content {
    margin-left: 250px;
    padding: 40px 30px; /* Ajustei o padding para aumentar o espaçamento */
    width: calc(100% - 250px);
    transition: margin-left 0.3s, width 0.3s;
    flex: 1;
    display: flex;
    flex-direction: column; /* Permitir que o conteúdo seja organizado em uma coluna */
    align-items: center;
}
.content.minimized {
    margin-left: 80px;
    width: calc(100% - 80px);
}
.content-container {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    flex-wrap: wrap;
    width: 100%;
}
.content-container .container {
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    max-width: 900px;
    width: 100%;
    margin-bottom: 40px; /* Adicionado para melhorar o espaçamento entre containers */
}
.img-fluid {
    height: auto;
    width: 100%;
    max-width: 400px;
    border-radius: 10px;
}
footer {
    background-color: #343a40;
    color: white;
    text-align: center;
    padding: 20px 0;
    position: fixed;
    width: calc(100% - 250px);
    bottom: 0;
    left: 250px;
    transition: left 0.3s, width 0.3s;
}

.card-link {
    display: block;
    color: #6c757d; /* Cinza neutro */
    font-size: 0.85rem;
    text-align: center;
    margin-top: 8px;
    text-decoration: none;
    cursor: pointer;
    transition: color 0.3s;
}

.card-link:hover {
    color: #343a40; /* Escurece um pouco no hover para indicar clicável */
}
footer.minimized {
    left: 80px;
    width: calc(100% - 80px);
}
.sidebar img {
    width: 80px;
    margin-bottom: 20px;
}
.menu-toggle {
    display: none;
    position: fixed;
    top: 20px;
    left: 20px;
    background-color: #343a40;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px;
    cursor: pointer;
    z-index: 1100;
}
@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
        z-index: 1000;
    }
    .sidebar.visible {
        transform: translateX(0);
    }
    .content {
        margin-left: 0;
        width: 100%;
        padding: 20px; /* Ajuste para melhor visualização em telas menores */
    }
    footer {
        left: 0;
        width: 100%;
    }
    .menu-toggle {
        display: block;
    }
    .content-container .container {
        padding: 20px;
    }
    .img-fluid {
        max-width: 100%;
        height: auto;
    }
}
.card {
    cursor: pointer;
    max-width: 300px;
    margin: 15px auto;
    border: none;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

.card:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

.card img {
    width: 100%;
    height: 350px; /* Aumenta a altura da imagem para um pouco mais de destaque */
    object-fit: cover; /* Mantém o corte proporcional sem distorção */
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

.card-body {
    padding: 10px 15px; /* Reduz o padding para minimizar espaço branco */
}

.card-title {
    font-size: 1.2rem;
    font-weight: bold;
    color: #343a40;
    margin-bottom: 5px; /* Reduz o espaço abaixo do título */
}

.card-text {
    font-size: 1rem;
    color: #6c757d;
    margin-top: 5px; /* Ajuste para reduzir o espaço entre o título e o texto */
}
.modal-body {
    text-align: left;
}
h1 {
    font-size: 2.5rem;
    font-weight: bold;
    color: #343a40;
    margin-bottom: 50px; /* Adiciona mais espaço abaixo do título principal */
    text-align: center; /* Garante que o título esteja sempre centralizado */
}
h5 {
    font-size: 1.6rem;
    font-weight: bold;
    color: #343a40;
    margin-bottom: 20px;
}
    .textotitulo {
        padding: 100px;
    }

    </style>
</head>
<body>
    <button class="menu-toggle" id="menuToggle"><i class="bi bi-list"></i></button>
    <div class="sidebar" id="sidebar">
    <img src="imgs/upe.png" alt="logo-upe">
    <a href="index.php"><i class="bi bi-people"></i> <span>MEMBROS CPA 2024-2026</span></a>
    <a href="sobre.php" class="active"><i class="bi bi-people"></i> <span>MEMBROS CSAs 2024-2026</span></a>
    <!-- Botão do menu dobrável -->
    <a href="#formulario-submenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <i class="bi bi-journal-check"></i> <span>Avaliação 2024</span>
    </a>
    
    <!-- Subitens do menu dobrável -->
    <div class="collapse" id="formulario-submenu">
    <a href="#" class="sub-item" data-toggle="modal" data-target="#registerModal"><i class="bi bi-person-plus"></i> <span>Primeiro Acesso</span></a>
        <a href="#" class="sub-item" data-toggle="modal" data-target="#loginModal"><i class="bi bi-box-arrow-in-right"></i> <span>Login</span></a>
        <a href="<?php echo $client->createAuthUrl(); ?>" class="sub-item"><i class="bi bi-google"></i> <span>Entrar com Google</span></a>
    </div>
    <a href="relatorios.php"><i class="bi bi-file-earmark-text"></i> <span>Relatórios</span></a>
    <a href="documentos.php"><i class="bi bi-file-earmark"></i> <span>Documentos</span></a>
    <a href="contato.php"><i class="bi bi-envelope"></i> <span>Contato</span></a>
</div>

<div class="container">
    <h2 class="text-center"><strong>CONHEÇA AS CSAs UPE – TRIÊNIO 2024-2026</strong></h2>


    
    <div class="row">
        <!-- Escola Politécnica de Pernambuco -->
        <div class="col-md-4">
            <div class="card" data-toggle="modal" data-target="#modal1">
                <img src="imgs/presidente.png" class="card-img-top" alt="Anna Lícia Miranda Costa">
                <div class="card-body">
                    <h5 class="card-title">Escola Politécnica de Pernambuco</h5>
                    <p class="card-text"><strong>Docente Principal:</strong> Anna Lúcia Miranda Costa (CPA)</p>
                    <span class="card-link" data-toggle="modal" data-target="#modal1">Clique para conhecer os membros</span>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modalLabel1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel1">Escola Politécnica de Pernambuco - Comissão</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Docentes:</strong> Anna Lúcia Miranda Costa (CPA), Manoel H. Nóbrega Marinho</p>
                        <p><strong>Técnicos-Administrativos:</strong> Thiago Ferreira de Vasconcelos, Leidjane de Souza Pereira</p>
                        <p><strong>Discentes:</strong> Vívia Layssa dos Santos Silva, Vítor Hugo da Silva Petiz</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Instituto de Ciências Biológicas -->
        <div class="col-md-4">
            <div class="card" data-toggle="modal" data-target="#modal2">
                <img src="https://via.placeholder.com/400" class="card-img-top" alt="Maria Emília Ferraz Almeida de Melo">
                <div class="card-body">
                    <h5 class="card-title">Instituto de Ciências Biológicas</h5>
                    <p class="card-text"><strong>Técnico-Administrativo Principal:</strong> Anna Michelle L. F. S. Santana (CPA)</p>
                    <span class="card-link" data-toggle="modal" data-target="#modal1">Clique para conhecer os membros</span>

                </div>
            </div>
        </div>
        <div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="modalLabel2" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel2">Instituto de Ciências Biológicas - Comissão</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Docentes:</strong> Maria Emília Ferraz Almeida de Melo, Juliana de Souza Rebouças</p>
                        <p><strong>Técnicos-Administrativos:</strong> Anna Michelle L. F. S. Santana (CPA), Ana Paula da Silva Ferreira</p>
                        <p><strong>Discentes:</strong> Paulo Ricardo Aloísio Filho, Matheus Rodrigues Torres Farias</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Campus Mata Sul -->
        <div class="col-md-4">
            <div class="card" data-toggle="modal" data-target="#modal3">
                <img src="https://via.placeholder.com/400" class="card-img-top" alt="Raquel Bianor da Silva">
                <div class="card-body">
                    <h5 class="card-title">Campus Mata Sul</h5>
                    <p class="card-text"><strong>Discente Principal:</strong> Lívia Mariane Lima dos Santos (CPA)</p>
                    <span class="card-link" data-toggle="modal" data-target="#modal1">Clique para conhecer os membros</span>

                </div>
            </div>
        </div>
        <div class="modal fade" id="modal3" tabindex="-1" role="dialog" aria-labelledby="modalLabel3" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel3">Campus Mata Sul - Comissão</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Docentes:</strong> Raquel Bianor da Silva, Rebeca Sá do Nascimento Carrazzoni</p>
                        <p><strong>Discentes:</strong> Lívia Mariane Lima dos Santos (CPA), Clara Helena Santos Monteiro de Almeida</p>
                        <p><strong>Técnicos-Administrativos:</strong> Graciet Elizangela Lima Mendonça, Jailson Wanderson de Lima Assis</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Faculdade de Enfermagem Nossa Senhora das Graças -->
        <div class="col-md-4">
            <div class="card" data-toggle="modal" data-target="#modal4">
                <img src="imgs/leozinaandradedocentefensg.jpg" class="card-img-top" alt="Leozina Barbosa de Andrade">
                <div class="card-body">
                    <h5 class="card-title">Faculdade de Enfermagem Nossa Senhora das Graças</h5>
                    <p class="card-text">Docente Principal: Leozina Barbosa de Andrade (CPA)</p>
                    <span class="card-link" data-toggle="modal" data-target="#modal1">Clique para conhecer os membros</span>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal4" tabindex="-1" role="dialog" aria-labelledby="modalLabel4" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel4">Faculdade de Enfermagem Nossa Senhora das Graças - Comissão</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Docentes:</strong> Leozina Barbosa de Andrade (CPA), Diego Augusto Lopes</p>
                        <p><strong>Técnicos-Administrativos:</strong> Dayane Rosa Fraga Lima, Márcia Cristina Mendes França</p>
                        <p><strong>Discentes:</strong> Sanderson Mendes do Nascimento, Davi de Oliveira Mendes</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Faculdade de Administração e Direito de Pernambuco -->
<div class="col-md-4">
    <div class="card" data-toggle="modal" data-target="#modal5">
        <img src="imgs/lucianasilvatecnicafcap.png" class="card-img-top" alt="Luciana de Kassia Arruda da Silva">
        <div class="card-body">
            <h5 class="card-title">Faculdade de Administração e Direito de Pernambuco</h5>
            <p class="card-text">Técnico-Administrativo Principal: Luciana de Kassia Arruda da Silva (CPA)</p>
            <span class="card-link" data-toggle="modal" data-target="#modal1">Clique para conhecer os membros</span>

        </div>
    </div>
</div>
<div class="modal fade" id="modal5" tabindex="-1" role="dialog" aria-labelledby="modalLabel5" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel5">Faculdade de Administração e Direito de Pernambuco - Comissão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Técnicos-Administrativos:</strong> Luciana de Kassia Arruda da Silva (CPA), Fernanda Vasconcelos Motta</p>
                <p><strong>Docentes:</strong> Manuela Abath Valença, Raíssa Souto Maior Corrêa de Carvalho</p>
                <p><strong>Discentes:</strong> Clara Porto Guimarães, Antônio Marcos Cavalcanti da Silva</p>
            </div>
        </div>
    </div>
</div>

<!-- Campus Mata Norte -->
<div class="col-md-4">
    <div class="card" data-toggle="modal" data-target="#modal5">
        <img src="imgs/vitorsantosdiscentematanorte.jpg" class="card-img-top" alt="Vítor Emanuel José dos Santos">
        <div class="card-body">
            <h5 class="card-title">Campus Mata Norte</h5>
            <p class="card-text">Discente Principal: Vítor Emanuel José dos Santos (CPA)</p>
            <span class="card-link" data-toggle="modal" data-target="#modal1">Clique para conhecer os membros</span>

        </div>
    </div>
</div>
<div class="modal fade" id="modal5" tabindex="-1" role="dialog" aria-labelledby="modalLabel5" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel5">Campus Mata Norte - Comissão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Discentes:</strong> Vítor Emanuel José dos Santos (CPA), Larissa Maria Elpídio da Silva</p>
                <p><strong>Docentes:</strong> Júlia Vilar Lemos, Leandro de Almeida Melo</p>
                <p><strong>Técnicos-Administrativos:</strong> Ana Paula Gomes da Silva, Paula Marianne Correia</p>
            </div>
        </div>
    </div>
</div>

<!-- Campus Arcoverde -->
<div class="col-md-4">
    <div class="card" data-toggle="modal" data-target="#modal5">
        <img src="imgs/claudiamotadocentearcoverde.jpg" class="card-img-top" alt="Cláudia Cristina Brainer de O. Mota">
        <div class="card-body">
            <h5 class="card-title">Campus Arcoverde</h5>
            <p class="card-text">Docente Principal: Cláudia Cristina Brainer de O. Mota (CPA)</p>
            <span class="card-link" data-toggle="modal" data-target="#modal1">Clique para conhecer os membros</span>

        </div>
    </div>
</div>
<div class="modal fade" id="modal5" tabindex="-1" role="dialog" aria-labelledby="modalLabel5" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel5">Campus Arcoverde - Comissão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Docentes:</strong> Cláudia Cristina Brainer de O. Mota (CPA), Paula Isabel Bezerra Rocha Wanderley</p>
                <p><strong>Técnicos-Administrativos:</strong> Deyverson de F. Barbosa Cordeiro, Romildo Luís do Nascimento Filho</p>
                <p><strong>Discentes:</strong> Maria Beatriz de Andrade Marques Seabra, Breno César Bastos de Souza</p>
            </div>
        </div>
    </div>
</div>

<!-- Campus Garanhuns -->
<div class="col-md-4">
    <div class="card" data-toggle="modal" data-target="#modal5">
        <img src="imgs/leylabragatecnicogaranhuns.jpeg" class="card-img-top" alt="Esther Leyla da Silva B. Wanderley">
        <div class="card-body">
            <h5 class="card-title">Campus Garanhuns</h5>
            <p class="card-text">Técnico-Administrativo Principal: Esther Leyla da Silva B. Wanderley (CPA)</p>
            <span class="card-link" data-toggle="modal" data-target="#modal1">Clique para conhecer os membros</span>

        </div>
    </div>
</div>
<div class="modal fade" id="modal5" tabindex="-1" role="dialog" aria-labelledby="modalLabel5" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel5">Campus Garanhuns - Comissão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Técnicos-Administrativos:</strong> Esther Leyla da Silva B. Wanderley (CPA), Danilo Tavares da Silva</p>
                <p><strong>Docentes:</strong> Patrícia Maria Tenório de Souza, Iwelton Madson Celestino Pereira</p>
                <p><strong>Discentes:</strong> Maria Augusta Nascimento de Moura, Anderson Burgos de Melo</p>
            </div>
        </div>
    </div>
</div>

<!-- Campus Salgueiro -->
<div class="col-md-4">
    <div class="card" data-toggle="modal" data-target="#modal5">
        <img src="imgs/anaclaradiscentesalgueiro.jpeg" class="card-img-top" alt="Ana Clara Alves Rocha">
        <div class="card-body">
            <h5 class="card-title">Campus Salgueiro</h5>
            <p class="card-text">Discente Principal: Ana Clara Alves Rocha (CPA)</p>
            <span class="card-link" data-toggle="modal" data-target="#modal1">Clique para conhecer os membros</span>

        </div>
    </div>
</div>
<div class="modal fade" id="modal5" tabindex="-1" role="dialog" aria-labelledby="modalLabel5" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel5">Campus Salgueiro - Comissão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Discentes:</strong> Ana Clara Alves Rocha (CPA), Luís Miguel Gonçalves Torres Ribeiro</p>
                <p><strong>Docentes:</strong> Tatyane Veras de Queiroz Ferreira da Cruz, Fagner José Coutinho de Melo</p>
                <p><strong>Técnicos-Administrativos:</strong> Mônica Rodrigues da Cruz, Luís Miguel Gonçalves Torres Ribeiro</p>
            </div>
        </div>
    </div>
</div>

<!-- Campus Petrolina -->
<div class="col-md-4">
    <div class="card" data-toggle="modal" data-target="#modal6">
        <img src="imgs/ritamuhledocentepetrolina.jpg" class="card-img-top" alt="Rita Paradeda Muhle">
        <div class="card-body">
            <h5 class="card-title">Campus Petrolina</h5>
            <p class="card-text">Docente Principal: Rita Paradeda Muhle (CPA)</p>
            <span class="card-link" data-toggle="modal" data-target="#modal1">Clique para conhecer os membros</span>

        </div>
    </div>
</div>
<div class="modal fade" id="modal6" tabindex="-1" role="dialog" aria-labelledby="modalLabel6" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel6">Campus Petrolina - Comissão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Docentes:</strong> Rita Paradeda Muhle (CPA), Wylma Danuzza Guimarães Bastos</p>
                <p><strong>Técnicos-Administrativos:</strong> Matheus Ricardo de Oliveira Souza, Jakeline Nunes da Silva Marcula</p>
                <p><strong>Discentes:</strong> Gabriela Matias de Castro, Gustavo Libório Matos</p>
            </div>
        </div>
    </div>
</div>

<!-- Reitoria -->
<div class="col-md-4">
    <div class="card" data-toggle="modal" data-target="#modal7">
        <img src="imgs/acaynenascimentotecnicoreitoria.jpeg" class="card-img-top" alt="Acayne Uluri B. do Nascimento">
        <div class="card-body">
            <h5 class="card-title">Reitoria</h5>
            <p class="card-text">Técnico-Administrativo Principal: Acayne Uluri B. do Nascimento (CPA)</p>
            <span class="card-link" data-toggle="modal" data-target="#modal1">Clique para conhecer os membros</span>

        </div>
    </div>
</div>
<div class="modal fade" id="modal7" tabindex="-1" role="dialog" aria-labelledby="modalLabel7" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel7">Reitoria - Comissão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Técnicos-Administrativos:</strong> Acayne Uluri B. do Nascimento (CPA), Priscila Sáuar da Cunha, Maria Clarice Alves de Oliveira de Neiva, Gleibson Gregorio da Silva, Caroline Alves Silva, Patrícia Nereide Lima Geoffroy</p>
            </div>
        </div>
    </div>
</div>

<!-- Faculdade de Ciências Médicas -->
<div class="col-md-4">
    <div class="card" data-toggle="modal" data-target="#modal8">
        <img src="imgs/brenopereiradiscentefcm.jpg" class="card-img-top" alt="Breno Pereira Teixeira">
        <div class="card-body">
            <h5 class="card-title">Faculdade de Ciências Médicas</h5>
            <p class="card-text">Discente Principal: Breno Pereira Teixeira (CPA)</p>
            <span class="card-link" data-toggle="modal" data-target="#modal1">Clique para conhecer os membros</span>

        </div>
    </div>
</div>
<div class="modal fade" id="modal8" tabindex="-1" role="dialog" aria-labelledby="modalLabel8" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel8">Faculdade de Ciências Médicas - Comissão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Discentes:</strong> Breno Pereira Teixeira (CPA), Daniella Kelly Ramos Aragão</p>
                <p><strong>Docentes:</strong> Marianne Regina Araújo Sabino, Márcia Andréia Oliveira da Cunha</p>
                <p><strong>Técnicos-Administrativos:</strong> Maysa Caroline da Silva Ribeiro, Marta Maria dos Santos</p>
            </div>
        </div>
    </div>
</div>

<!-- Escola Superior de Educação Física -->
<div class="col-md-4">
    <div class="card" data-toggle="modal" data-target="#modal9">
        <img src="imgs/fabioteixeiradocenteesef.jpeg" class="card-img-top" alt="Fabio Luis Santos Teixeira">
        <div class="card-body">
            <h5 class="card-title">Escola Superior de Educação Física</h5>
            <p class="card-text">Docente Principal: Fabio Luis Santos Teixeira (CPA)</p>
            <span class="card-link" data-toggle="modal" data-target="#modal1">Clique para conhecer os membros</span>

        </div>
    </div>
</div>
<div class="modal fade" id="modal9" tabindex="-1" role="dialog" aria-labelledby="modalLabel9" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel9">Escola Superior de Educação Física - Comissão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Docentes:</strong> Fabio Luis Santos Teixeira (CPA), Denise Maria Martins Vancea</p>
                <p><strong>Técnicos-Administrativos:</strong> Maria do Socorro Alves de Lima, Aliciana Maria Bezerra Barros</p>
                <p><strong>Discentes:</strong> Luana Mirela Arruda da Silva, Jorge Miguel Reis Galindo</p>
            </div>
        </div>
    </div>
</div>

<!-- Proto-Socorro Cardiológico Universitário de Pernambuco -->
<div class="col-md-4">
    <div class="card" data-toggle="modal" data-target="#modal10">
        <img src="imgs/katiafreitastecnicoprocape.jpeg" class="card-img-top" alt="Kátia Cristina de S.N. Freitas da Silva">
        <div class="card-body">
            <h5 class="card-title">Proto-Socorro Cardiológico Universitário de Pernambuco</h5>
            <p class="card-text">Técnico-Administrativo Principal: Kátia Cristina de S.N. Freitas da Silva (CPA)</p>
            <span class="card-link" data-toggle="modal" data-target="#modal1">Clique para conhecer os membros</span>

        </div>
    </div>
</div>
<div class="modal fade" id="modal10" tabindex="-1" role="dialog" aria-labelledby="modalLabel10" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel10">Proto-Socorro Cardiológico Universitário de Pernambuco - Comissão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Técnicos-Administrativos:</strong> Kátia Cristina de S.N. Freitas da Silva (CPA), Ozilane Maria Gomes Tavares, Juliana Santos Silva Ramos, Luiz Eduardo da Costa Gomes, Fabiana Vieira de Melo, Matheus Vinícius Barbosa da Silva</p>
            </div>
        </div>
    </div>
</div>

<!-- Campus Ouricuri -->
<div class="col-md-4">
    <div class="card" data-toggle="modal" data-target="#modal11">
        <img src="imgs/paulalaisdiscenteouricuri.jpg" class="card-img-top" alt="Paula Laís Borges de Carvalho">
        <div class="card-body">
            <h5 class="card-title">Campus Ouricuri</h5>
            <p class="card-text">Discente Principal: Paula Laís Borges de Carvalho (CPA)</p>
            <span class="card-link" data-toggle="modal" data-target="#modal1">Clique para conhecer os membros</span>

        </div>
    </div>
</div>
<div class="modal fade" id="modal11" tabindex="-1" role="dialog" aria-labelledby="modalLabel11" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel11">Campus Ouricuri - Comissão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Discentes:</strong> Paula Laís Borges de Carvalho (CPA), Jean Ferreira Lun</p>
                <p><strong>Docentes:</strong> Renata Evaristo Rodrigues Duarte</p>
                <p><strong>Técnicos-Administrativos:</strong> Não informado</p>
            </div>
        </div>
    </div>
</div>

<!-- Faculdade de Odontologia de Pernambuco -->
<div class="col-md-4">
    <div class="card" data-toggle="modal" data-target="#modal12">
        <img src="imgs/elianasantosdocentefop.jpeg" class="card-img-top" alt="Eliana Santos Lyra da Paz">
        <div class="card-body">
            <h5 class="card-title">Faculdade de Odontologia de Pernambuco</h5>
            <p class="card-text">Docente Principal: Eliana Santos Lyra da Paz (CPA)</p>
            <span class="card-link" data-toggle="modal" data-target="#modal1">Clique para conhecer os membros</span>

        </div>
    </div>
</div>
<div class="modal fade" id="modal12" tabindex="-1" role="dialog" aria-labelledby="modalLabel12" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel12">Faculdade de Odontologia de Pernambuco - Comissão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Docentes:</strong> Eliana Santos Lyra da Paz (CPA), Rosana Maria Coelho Travassos</p>
                <p><strong>Técnicos-Administrativos:</strong> Stefany de Lima Duarte, Maria Augusta Uchôa de A. Barros</p>
                <p><strong>Discentes:</strong> Marília Carvalho Aguiar, Maria Eduarda de Moura Silva</p>
            </div>
        </div>
    </div>
</div>

<!-- Hospital Universitário Oswaldo Cruz -->
<div class="col-md-4">
    <div class="card" data-toggle="modal" data-target="#modal13">
        <img src="https://via.placeholder.com/400" class="card-img-top" alt="Fernanda Calixto do Prado Van Agt">
        <div class="card-body">
            <h5 class="card-title">Hospital Universitário Oswaldo Cruz</h5>
            <p class="card-text">Técnico-Administrativo Principal: Fernanda Calixto do Prado Van Agt (CPA)</p>
            <span class="card-link" data-toggle="modal" data-target="#modal1">Clique para conhecer os membros</span>

        </div>
    </div>
</div>
<div class="modal fade" id="modal13" tabindex="-1" role="dialog" aria-labelledby="modalLabel13" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel13">Hospital Universitário Oswaldo Cruz - Comissão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Técnicos-Administrativos:</strong> Fernanda Calixto do Prado Van Agt (CPA), Marcelle de Barros e Silva Torres, Mônica Maria Barbosa Teófilo, Nalba Lúcia de Oliveira, Alexandre Thadeu Neto de Oliveira Filho, Brunna Francisca de Farias Aragão</p>
            </div>
        </div>
    </div>
</div>

<!-- Campus Caruaru -->
<div class="col-md-4">
    <div class="card" data-toggle="modal" data-target="#modal14">
        <img src="imgs/rayssasilvadiscentecaruaru.jpeg" class="card-img-top" alt="Rayssa Carla Leal da Silva">
        <div class="card-body">
            <h5 class="card-title">Campus Caruaru</h5>
            <p class="card-text">Discente Principal: Raysa Carla Leal da Silva (CPA)</p>
            <span class="card-link" data-toggle="modal" data-target="#modal1">Clique para conhecer os membros</span>

        </div>
    </div>
</div>
<div class="modal fade" id="modal14" tabindex="-1" role="dialog" aria-labelledby="modalLabel14" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel14">Campus Caruaru - Comissão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Discentes:</strong> Raysa Carla Leal da Silva (CPA), Bianca Maria Leal da Silva</p>
                <p><strong>Docentes:</strong> Bartira Pereira Amorim Confessor, Robson Góes de Carvalho</p>
                <p><strong>Técnicos-Administrativos:</strong> Renata Torres Colaço Nascimento Figueroa, Rosie Cleide Pereira Alves Tenório</p>
            </div>
        </div>
    </div>
</div>

<!-- Campus Serra Talhada -->
<div class="col-md-4">
    <div class="card" data-toggle="modal" data-target="#modal15">
        <img src="https://via.placeholder.com/400" class="card-img-top" alt="Antônio Wilton Cavalcante Fernandes">
        <div class="card-body">
            <h5 class="card-title">Campus Serra Talhada</h5>
            <p class="card-text">Docente Principal: Antônio Wilton Cavalcante Fernandes (CPA)</p>
            <span class="card-link" data-toggle="modal" data-target="#modal1">Clique para conhecer os membros</span>

        </div>
    </div>
</div>
<div class="modal fade" id="modal15" tabindex="-1" role="dialog" aria-labelledby="modalLabel15" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel15">Campus Serra Talhada - Comissão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Docentes:</strong> Antônio Wilton Cavalcante Fernandes (CPA), Marcelo Ferreira Leite</p>
                <p><strong>Técnicos-Administrativos:</strong> Pedro Vinícius Alcântara Oliveira, Dávila Maria Feitosa da Silva</p>
                <p><strong>Discentes:</strong> Anna Carolyne Barbosa Farias, Maria Eduarda Souza da Silva</p>
            </div>
        </div>
    </div>
</div>

<!-- Centro Universitário Integrado de Saúde Amaury Medeiros -->
<div class="col-md-4">
    <div class="card" data-toggle="modal" data-target="#modal20">
        <img src="imgs/mariadjanetetecnicacisam.jpeg" class="card-img-top" alt="Maria Djaneete de Oliveira">
        <div class="card-body">
            <h5 class="card-title">Centro Universitário Integrado de Saúde Amaury Medeiros</h5>
            <p class="card-text">Técnico Principal: Maria Djanete de Oliveira (CPA)</p>
            <span class="card-link" data-toggle="modal" data-target="#modal1">Clique para conhecer os membros</span>

        </div>
    </div>
</div>
<div class="modal fade" id="modal20" tabindex="-1" role="dialog" aria-labelledby="modalLabel20" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel20">Centro Universitário Integrado de Saúde Amaury Medeiros - Comissão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Técnicos-Administrativos:</strong> Maria Djaneete de Oliveira (CPA), Maria de Fátima Silva Souza, Raquel da Silva Menezes, Victória Azevedo, Alessandra Teixeira da Câmara Araújo, Suzemires Marcia Lopes Sobral Barbosa da Silva</p>
            </div>
        </div>
    </div>
</div>


<!-- Campus Surubim -->
<div class="col-md-4">
    <div class="card" data-toggle="modal" data-target="#modal16">
        <img src="https://via.placeholder.com/400" class="card-img-top" alt="José Everson da Silva Santos">
        <div class="card-body">
            <h5 class="card-title">Campus Surubim</h5>
            <p class="card-text">Discente Principal: José Everson da Silva Santos (CPA)</p>
            <span class="card-link" data-toggle="modal" data-target="#modal1">Clique para conhecer os membros</span>

        </div>
    </div>
</div>
<div class="modal fade" id="modal16" tabindex="-1" role="dialog" aria-labelledby="modalLabel16" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel16">Campus Surubim - Comissão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Discentes:</strong> José Everson da Silva Santos (CPA), Lívia Maria Dura Galvão</p>
                <p><strong>Docentes:</strong> Gevson Silva Andrade, Augusto Cesar Ferreira M. Oliveira</p>
                <p><strong>Técnicos-Administrativos:</strong> Graciet Elizangela Lima Mendonça, Jailson Wanderson de Lima Assis</p>
            </div>
        </div>
    </div>
</div>

<!-- Superintendência do Complexo Hospitalar -->
<div class="col-md-4">
    <div class="card" data-toggle="modal" data-target="#modal17">
        <img src="imgs/marianesabinodocentecpx.jpg" class="card-img-top" alt="Marianne Regina Araújo Sabino">
        <div class="card-body">
            <h5 class="card-title">Superintendência do Complexo Hospitalar</h5>
            <p class="card-text">Docente Principal: Marianne Regina Araújo Sabino (CPA)</p>
            <span class="card-link" data-toggle="modal" data-target="#modal1">Clique para conhecer os membros</span>

        </div>
    </div>
</div>
<div class="modal fade" id="modal17" tabindex="-1" role="dialog" aria-labelledby="modalLabel17" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel17">Superintendência do Complexo Hospitalar - Comissão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Principal:</strong> Marianne Regina Araújo Sabino (CPA)</p>
                <p><strong>Membro:</strong> André de Barros e Baltar Fernandes Ribeiro</p>
            </div>
        </div>
    </div>
</div>

<!-- Secretaria de Ciência, Tecnologia e Inovação de Pernambuco -->
<div class="col-md-4">
    <div class="card" data-toggle="modal" data-target="#modal18">
        <img src="imgs/kentsbonattisecti.jpeg" class="card-img-top" alt="Kenys Bonatti Maziero">
        <div class="card-body">
            <h5 class="card-title">Secretaria de Ciência, Tecnologia e Inovação de Pernambuco</h5>
            <p class="card-text">Principal: Kents Bonatti Maziero (CPA)</p>
            <span class="card-link" data-toggle="modal" data-target="#modal1">Clique para conhecer os membros</span>

        </div>
    </div>
</div>
<div class="modal fade" id="modal18" tabindex="-1" role="dialog" aria-labelledby="modalLabel18" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel18">Secretaria de Ciência, Tecnologia e Inovação de Pernambuco - Comissão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Principal:</strong> Kenys Bonatti Maziero (CPA)</p>
                <p><strong>Membro:</strong> Marília Mesquita de Amorim Figueiredo</p>
            </div>
        </div>
    </div>
</div>

<!-- Sociedade Civil -->
<div class="col-md-4">
    <div class="card" data-toggle="modal" data-target="#modal19">
        <img src="imgs/edmilsondasilvasociedadecivil.png" class="card-img-top" alt="Edmilson José Da Silva">
        <div class="card-body">
            <h5 class="card-title">Sociedade Civil</h5>
            <p class="card-text">Principal: Edmilson José Da Silva (CPA)</p>
            <span class="card-link" data-toggle="modal" data-target="#modal1">Clique para conhecer os membros</span>

        </div>
    </div>
</div>
<div class="modal fade" id="modal19" tabindex="-1" role="dialog" aria-labelledby="modalLabel19" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel19">Sociedade Civil - Comissão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Principal:</strong> Edmilson José Da Silva (CPA)</p>
            </div>
        </div>
    </div>
</div>

    </div>
</div>
    <!-- Modal de Login -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="config/login.php" method="POST">
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Senha:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Registro -->
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Registro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="modal-dialog" style="color: #ff0000"><strong>Importante:</strong> Registre-se, preferencialmente, usando seu e-mail institucional.</p>
                    <form action="config/register.php" method="POST">
                        <div class="form-group">
                            <label for="full_name">Nome completo:</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Senha:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="afiliacoes">Afiliações:</label><br>
                            <input type="checkbox" name="afiliacoes[]" value="Docente"> Docente<br>
                            <input type="checkbox" name="afiliacoes[]" value="Discente"> Discente<br>
                            <input type="checkbox" name="afiliacoes[]" value="Servidores Técnico-Administrativos"> Servidores Técnico-Administrativos<br>
                            <input type="checkbox" name="afiliacoes[]" value="Estudante"> Estudante<br>
                            <input type="checkbox" name="afiliacoes[]" value="Egresso"> Egresso<br>
                        </div>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('menuToggle').addEventListener('click', function() {
                document.getElementById('sidebar').classList.toggle('visible');
            });

            document.getElementById('toggleSidebar').addEventListener('click', function() {
                document.getElementById('sidebar').classList.toggle('minimized');
                document.getElementById('content').classList.toggle('minimized');
                document.getElementById('footer').classList.toggle('minimized');
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
