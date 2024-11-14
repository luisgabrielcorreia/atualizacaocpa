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
            padding: 20px;
            width: calc(100% - 250px);
            transition: margin-left 0.3s, width 0.3s;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
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
                padding: 15px;
            }
            footer {
                left: 0;
                width: 100%;
            }
            .menu-toggle {
                display: block;
            }
            .content-container .container {
                padding: 15px;
            }
            .img-fluid {
                max-width: 100%;
                height: auto;
            }
        }
    </style>
</head>
<body>
    <button class="menu-toggle" id="menuToggle"><i class="bi bi-list"></i></button>
    <div class="sidebar" id="sidebar">
    <img src="imgs/upe.png" alt="logo-upe">
    <a href="index.php"><i class="bi bi-people"></i> <span>MEMBROS CPA 2024-2026</span></a>
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
    <a href="documentos.php" class="active"><i class="bi bi-file-earmark"></i> <span>Documentos</span></a>
    <a href="contato.php"><i class="bi bi-envelope"></i> <span>Contato</span></a>
</div>
    <div class="content" id="content">
    <div class="content-container">
        <div class="container">
            <h2 class="mb-4">Documentos CPA:</h2>
            <div class="list-group">
                <a href="https://drive.google.com/file/d/1frB-DkoNh5s_OhjIrogkQyucSgWardpv/view?usp=sharing" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-file-pdf me-3" style="font-size: 1.5rem; color: #ff0000;"></i> Regulamento da CPA
                </a>
                <a href="https://drive.google.com/uc?export=download&id=1VNSxpbTj-wpBsTE5Eh2-2tsVniaNrLhk" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-file-pdf me-3" style="font-size: 1.5rem; color: #ff0000;"></i> Portaria Nº 2639 de 2023: Membros da Comissão Própria de Avaliação para o período de 2021 a 2024
                </a>
                <a href="https://drive.google.com/uc?export=download&id=130vTlQi1a9YTmgd8Lc8ard7K2M3eKSzi" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-file-pdf me-3" style="font-size: 1.5rem; color: #ff0000;"></i> Portaria Nº 1998 de 2023: Membros da Comissão Setorial de Avaliação nas Unidades de Ensino e de Saúde da UPE para o período de 2021 a 2024
                </a>
                <a href="https://drive.google.com/file/d/1X7zr1_CXsRtNt-lpQGCA6pNIou5YI__-/view?usp=sharing" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-file-pdf me-3" style="font-size: 1.5rem; color: #ff0000;"></i> Portaria Nº 1685 de 2021: Membros da Comissão Setorial de Avaliação nas Unidades de Ensino e de Saúde da UPE para o período de 2021 a 2024.
                </a>
                <a href="https://drive.google.com/file/d/1-tyQgq2bhvs2exsQrpOGbdW2_kpu38Pk/view?usp=sharing" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-file-pdf me-3" style="font-size: 1.5rem; color: #ff0000;"></i> Portaria Nº 1598 de 2021: Membros da Comissão Própria de Avaliação para o período de 2021 a 2024.
                </a>
                <a href="https://drive.google.com/file/d/1aNASOwIy6MkM7-lOoiyydVStCsp2L0N9/view?usp=sharing" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-file-pdf me-3" style="font-size: 1.5rem; color: #ff0000;"></i> Portaria Nº 1804 de 2017: Membros da Comissão Própria De Avaliação de 2017- 2020
                </a>
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
                    <!-- Link de Esqueceu a Senha -->
                    <div class="text-center mt-3 mb-4">
                        <button type="button" class="btn btn-link" onclick="openForgotPasswordModal()">
                            Esqueceu sua senha?
                        </button>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Esqueceu a Senha -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="forgotPasswordModalLabel">Esqueceu sua senha?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Para redefinir sua senha, envie um e-mail para <strong>cpa@upe.br</strong> com o assunto "Recuperação de Senha". Nossa equipe entrará em contato para ajudá-lo a redefinir sua senha.</p>
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
        function openForgotPasswordModal() {
            $('#loginModal').modal('hide'); // Fecha o modal de login
            $('#forgotPasswordModal').modal('show'); // Abre o modal de "Esqueceu a Senha"
        }
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
