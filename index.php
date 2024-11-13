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
    <title>Comissão Própria de Avaliação - UPE</title>
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
    background-color: #f0f2f5; /* Fundo suave para reduzir o excesso de branco */
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
    padding: 60px 20px 20px; /* Espaçamento superior */
    width: calc(100% - 250px);
    transition: margin-left 0.3s, width 0.3s;
    flex: 1;
    display: flex;
    justify-content: center;
    box-sizing: border-box; /* Para garantir que padding não afete a largura */
}

.content.minimized {
    margin-left: 80px;
    width: calc(100% - 80px);
}

.content-container {
    width: 100%;
    max-width: 900px;
    background-color: #ffffff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: none; /* Sombra para destaque */
    border: none; /* Borda suave ao redor do container */
    background-color: transparent;
}

/* Fundo de destaque para o conteúdo */
.content h2 {
    font-size: 1.8rem;
    font-weight: bold;
    color: #343a40;
    margin-bottom: 20px;
}

.content h3 {
    font-size: 1.4rem;
    color: #495057;
    margin-bottom: 15px;
    background-color: #e9ecef; /* Fundo de destaque para títulos */
    padding: 10px;
    border-radius: 5px;
}

/* Divisórias entre seções */
.section-divider {
    border-top: 1px solid #dcdcdc;
    margin: 30px 0;
}

.card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
    background-color: #ffffff;
}

/* Linha divisória para cada card */
.card-divider {
    height: 1px;
    background-color: #e0e0e0;
    margin: 15px 0;
}

.card-title {
    font-size: 1.1rem;
    color: #343a40;
    font-weight: bold;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100%; /* Garante que o texto não ultrapasse a largura do card */
}

.card:hover {
    transform: scale(1.05);
}

.card img {
    width: 100% !important;
    height: 250px !important; /* Ajuste a altura conforme desejado */
    object-fit: cover !important; /* Garante o ajuste da imagem dentro da área definida */
    display: block;
    aspect-ratio: 3 / 4; /* Define uma proporção para as imagens, ajuste conforme necessário */
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

.row .card {
    width: 100%; /* Garante que os cards ocupem toda a largura da coluna */
    max-width: 250px; /* Define uma largura máxima para uniformizar os cards */
    height: 100%; /* Faz com que os cards ocupem a altura total da coluna */
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* Distribui o conteúdo de forma equilibrada */
    margin: 0 auto; /* Centraliza os cards */
}

.card h5 {
    font-size: 1.1rem;
    color: #343a40;
    font-weight: bold;
}

.card p {
    font-size: 0.9rem;
    color: #6c757d;
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
    }
    footer {
        left: 0;
        width: 100%;
    }
    .menu-toggle {
        display: block;
    }
}

/* Estilo para o submenu */
#formulario-submenu {
    width: 100%; /* Garante que o submenu usa toda a largura da sidebar */
}

/* Estilo para subitens do menu dobrável */
.sub-item {
    padding-left: 30px; /* Indenta os subitens para diferenciá-los */
    font-size: 0.9rem; /* Diminui o tamanho da fonte dos subitens */
    color: #ddd;
}

.sub-item:hover {
    background-color: #495057;
    color: white;
}

/* Estilos para a sidebar minimizada */
.sidebar.minimized a {
    justify-content: center;
}

.sidebar.minimized #formulario-submenu a span,
.sidebar.minimized a span {
    display: none; /* Oculta o texto ao minimizar */
}

.sidebar.minimized #formulario-submenu .sub-item {
    padding-left: 10px; /* Menor recuo para o submenu na versão minimizada */
}


    </style>
</head>
<body>
    <button class="menu-toggle" id="menuToggle"><i class="bi bi-list"></i></button>
    <div class="sidebar" id="sidebar">
    <img src="imgs/upe.png" alt="logo-upe">
    <a href="index.php" class="active"><i class="bi bi-people"></i> <span>MEMBROS CPA 2024-2026</span></a>
    <a href="sobre.php"><i class="bi bi-people"></i> <span>MEMBROS CSAs 2024-2026</span></a>
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
    
    <div class="content" id="content">
    <div class="content-container">
        <h2 class="text-center">CONHEÇA A CPA UPE – TRIÊNIO 2024-2026</h2>

        <!-- Seção do Presidente -->
        <div class="row justify-content-center mb-5">
            <div class="col-md-6 col-lg-4">
                <h3 class="text-center">Presidente</h3>
                <div class="card text-center">
                    <img src="imgs/presidente.png" class="card-img-top" alt="Presidente">
                    <div class="card-body">
                        <h5 class="card-title">Anna Lúcia Miranda</h5>
                        <p class="card-text">Presidente</p>
                        <p class="card-text"><strong>POLI</strong></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-divider"></div>

        <!-- Seção dos Docentes -->
        <h3 class="text-center">Docentes</h3>
        <div class="row mb-4">
            <?php 
            $docentes = [
                ["nome" => "Prof. Cláudia Mota", "cargo" => "Docente", "unidade" => "ARCOVERDE", "foto" => "claudiamotadocentearcoverde.jpg"],
                ["nome" => "Prof. Eliana Santos", "cargo" => "Docente", "unidade" => "FOP", "foto" => "elianasantosdocentefop.jpeg"],
                ["nome" => "Prof. Fábio Teixeira", "cargo" => "Docente", "unidade" => "ESEF", "foto" => "fabioteixeiradocenteesef.jpeg"],
                ["nome" => "Prof. Leozina Andrade", "cargo" => "Docente", "unidade" => "FENSG", "foto" => "leozinaandradedocentefensg.jpg"],
                ["nome" => "Prof. Rita Muhle", "cargo" => "Docente", "unidade" => "PETROLINA", "foto" => "ritamuhledocentepetrolina.jpg"],
                ["nome" => "Prof. Mariane Sabino", "cargo" => "Docente", "unidade" => "COMPLEXO HOSPITALAR", "foto" => "marianesabinodocentecpx.jpg"],
            ];
            foreach ($docentes as $docente): ?>
                <div class="col-md-4 col-sm-6 mb-4 d-flex align-items-stretch">
                    <div class="card text-center">
                        <img src="imgs/<?= $docente['foto'] ?>" class="card-img-top" alt="<?= $docente['nome'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $docente['nome'] ?></h5>
                            <div class="card-divider"></div>
                            <p class="card-text"><?= $docente['cargo'] ?></p>
                            <p class="card-text"><strong><?= $docente['unidade'] ?></strong></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="section-divider"></div>

        <!-- Seção dos Discentes -->
        <h3 class="text-center">Discentes</h3>
        <div class="row mb-4">
            <?php 
            $discentes = [
                ["nome" => "Ana Clara", "cargo" => "Discente", "unidade" => "SALGUEIRO", "foto" => "anaclaradiscentesalgueiro.jpeg"],
                ["nome" => "Breno Pereira", "cargo" => "Discente", "unidade" => "FCM", "foto" => "brenopereiradiscentefcm.jpg"],
                ["nome" => "Paula Lais", "cargo" => "Discente", "unidade" => "OURICURI", "foto" => "paulalaisdiscenteouricuri.jpg"],
                ["nome" => "Vitor Santos", "cargo" => "Discente", "unidade" => "MATA NORTE", "foto" => "vitorsantosdiscentematanorte.jpg"],
                ["nome" => "Rayssa Carla", "cargo" => "Discente", "unidade" => "CARUARU", "foto" => "rayssasilvadiscentecaruaru.jpeg"],
                ["nome" => "Lívia Mariane Lima", "cargo" => "Discente", "unidade" => "MATA SUL", "foto" => ".jpg"],
                ["nome" => "Jóse Everson da Silva", "cargo" => "Discente", "unidade" => "SURUBIM", "foto" => ".jpg"],


            ];
            foreach ($discentes as $discente): ?>
                <div class="col-md-4 col-sm-6 mb-4 d-flex align-items-stretch">
                    <div class="card text-center">
                        <img src="imgs/<?= $discente['foto'] ?>" class="card-img-top" alt="<?= $discente['nome'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $discente['nome'] ?></h5>
                            <div class="card-divider"></div>
                            <p class="card-text"><?= $discente['cargo'] ?></p>
                            <p class="card-text"><strong><?= $discente['unidade'] ?></strong></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="section-divider"></div>

                        <!-- Seção dos TECNICOS -->
        <h3 class="text-center">Técnicos</h3>
        <div class="row mb-4">
            <?php 
            $tecnicos = [
                ["nome" => "Acayne Nascimento", "cargo" => "Técnico", "unidade" => "REITORIA", "foto" => "acaynenascimentotecnicoreitoria.jpeg"],
                ["nome" => "Katia Freitas", "cargo" => "Técnicos", "unidade" => "PROCAPE", "foto" => "katiafreitastecnicoprocape.jpeg"],
                ["nome" => "Leyla Braga", "cargo" => "Técnico", "unidade" => "GARANHUNS", "foto" => "leylabragatecnicogaranhuns.jpeg"],
                ["nome" => "Anna Mychelle", "cargo" => "Técnico", "unidade" => "ICB", "foto" => ".jpeg"],
                ["nome" => "Fernanda Vasconcelos", "cargo" => "Técnico", "unidade" => "FCAP", "foto" => ".jpeg"],
                ["nome" => "Fernanda Calixto", "cargo" => "Técnico", "unidade" => "HUOC", "foto" => ".jpeg"],
                ["nome" => "Maria Djanete", "cargo" => "Técnico", "unidade" => "CISAM", "foto" => "mariadjanetetecnicacisam.jpeg"],
            ];
            foreach ($tecnicos as $tecnicos): ?>
               <div class="col-md-4 col-sm-6 mb-4 d-flex align-items-stretch">
                    <div class="card text-center">
                        <img src="imgs/<?= $tecnicos['foto'] ?>" class="card-img-top" alt="<?= $tecnicos['nome'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $tecnicos['nome'] ?></h5>
                            <div class="card-divider"></div>
                            <p class="card-text"><?= $tecnicos['cargo'] ?></p>
                            <p class="card-text"><strong><?= $tecnicos['unidade'] ?></strong></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="section-divider"></div>

                        <!-- Seção dos SECTI -->
                        <h3 class="text-center">Secti</h3>
        <div class="row mb-4">
            <?php 
            $secti = [
                ["nome" => "Kents Bonatti", "cargo" => "SECTI", "unidade" => "", "foto" => "kentsbonattisecti.jpeg"],
                ["nome" => "Marília Mesquita", "cargo" => "SECTI", "unidade" => "", "foto" => "mariliamesquitasecti.jpg"],
            ];
            foreach ($secti as $secti): ?>
                <div class="col-md-4 col-sm-6 mb-4 d-flex align-items-stretch">
                    <div class="card text-center">
                        <img src="imgs/<?= $secti['foto'] ?>" class="card-img-top" alt="<?= $secti['nome'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $secti['nome'] ?></h5>
                            <div class="card-divider"></div>
                            <p class="card-text"><?= $secti['cargo'] ?></p>
                            <p class="card-text"><strong><?= $secti['unidade'] ?></strong></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
                
        <div class="section-divider"></div>

        <!-- Seção da Sociedade Civil -->
        <h3 class="text-center">Sociedade Civil</h3>
        <div class="row mb-4">
            <?php 
            $sociedade_civil = [
                ["nome" => "Edmilson da Silva", "cargo" => "SOCIEDADE CIVIL", "foto" => "edmilsondasilvasociedadecivil.png"],
            ];
            foreach ($sociedade_civil as $membro): ?>
                <div class="col-md-4 col-sm-6 mb-4 d-flex align-items-stretch">
                    <div class="card text-center">
                        <img src="imgs/<?= $membro['foto'] ?>" class="card-img-top" alt="<?= $membro['nome'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $membro['nome'] ?></h5>
                            <div class="card-divider"></div>
                            <p class="card-text"><?= $membro['cargo'] ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
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
                    <form id="registerForm" action="config/register.php" method="POST">
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
                            <input type="checkbox" name="afiliacoes[]" value="Egresso"> Egresso<br>
                            <small style="color: #ff0000" id="affiliationError"></small>
                        </div>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                        <div id="registerError" style="color: #ff0000; margin-top: 10px;"></div> <!-- Div para exibir o erro -->
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
    <script>
        document.getElementById("registerForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Impede o envio padrão do formulário

            // Validação de afiliações
            const checkboxes = document.querySelectorAll('input[name="afiliacoes[]"]');
            let selected = false;

            checkboxes.forEach((checkbox) => {
                if (checkbox.checked) {
                    selected = true;
                }
            });

            if (!selected) {
                document.getElementById("affiliationError").innerText = "Por favor, selecione pelo menos uma afiliação.";
                return;
            } else {
                document.getElementById("affiliationError").innerText = "";
            }

            // Preparação do AJAX
            const formData = new FormData(document.getElementById("registerForm"));
            fetch("config/register.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json()) // Converte a resposta para JSON
            .then(data => {
                if (data.status === "error") {
                    document.getElementById("registerError").innerText = data.message; // Exibe a mensagem de erro
                } else if (data.status === "success") {
                    window.location.href = "public/user_dashboard.php"; // Redireciona em caso de sucesso
                }
            })
            .catch(error => {
                document.getElementById("registerError").innerText = "Erro ao processar o registro. Tente novamente.";
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
