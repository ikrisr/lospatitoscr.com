<?php
require_once __DIR__ . '/../config/start_app.php';
require_once __DIR__ . '/../config/database.php';

// si el usuario ya inició sesión, redirigir según su rol
if (isset($_SESSION["usuario"]) && isset($_SESSION["rol"])) {
    switch ($_SESSION["rol"]) {
        case 1:
            header("Location: dashboard_superadmin.php");
            exit();
        case 2:
        case 3:
            header("Location: index.php");
            exit();
    }
}

// procesar formulario de inicio de sesión
// procesar formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario  = trim($_POST["username"] ?? '');
    $password = trim($_POST["password"] ?? '');

    if ($usuario === '' || $password === '') {
        $_SESSION["error"] = "Por favor, complete todos los campos";
        header("Location: login.php");
        exit();
    }

    try {
        // crear conexión PDO
        $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        // obtener usuario según tu tabla real
        $stmt = $pdo->prepare("
            SELECT
                id,
                username,
                password,
                rol_id,
                activo
            FROM usuarios
            WHERE username = ?
            LIMIT 1
        ");
        $stmt->execute([$usuario]);
        $user_data = $stmt->fetch();

        // usuario encontrado, activo y contraseña correcta
        if ($user_data && (int)$user_data['activo'] === 1 && password_verify($password, $user_data['password'])) {

            session_regenerate_id(true);

            $_SESSION["usuario"] = $user_data['username'];
            $_SESSION["user_id"] = $user_data['id'];
            $_SESSION["rol"]     = (int)$user_data['rol_id'];

            unset($_SESSION["error"]);

            switch ((int)$_SESSION["rol"]) {
                case 1: // Superadministrador
                    header("Location: dashboard_superadmin.php");
                    exit();
                case 2: // Operador
                case 3: // Usuario
                default:
                    header("Location: index.php");
                    exit();
            }

        } else {
            $_SESSION["error"] = "Usuario o contraseña incorrectos";
            header("Location: login.php");
            exit();
        }

    } catch (PDOException $e) {
        error_log("Error de base de datos en login: " . $e->getMessage());
        $_SESSION["error"] = "Error del sistema. Intente más tarde.";
        header("Location: login.php");
        exit();
    }
}


// mostrar mensaje de error si existe
$error = $_SESSION["error"] ?? "";
unset($_SESSION["error"]);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión - Los Patitos CR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            min-height: 100vh;
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #f5f7fb;
            display: flex;
            align-items: center;       /* centra vertical */
            justify-content: center;   /* centra horizontal */
        }

        .login-wrapper {
            width: 100%;
            max-width: 900px;
        }

        .login-card {
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 12px 30px rgba(0,0,0,0.08);
            background: #fff;
        }

        .login-image-side {
            background: linear-gradient(135deg, #0d6efd, #00b4d8);
            color: #fff;
        }

        .login-image-side h2 {
            font-weight: 700;
        }

        .form-side {
            padding: 3rem 2.5rem;
        }

        .form-control {
            border-radius: 12px;
        }

        .btn-primary {
            border-radius: 12px;
            font-weight: 600;
            padding: 0.7rem 1rem;
        }

        @media (max-width: 767.98px) {
            .login-image-side {
                display: none;
            }
            .form-side {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="row g-0 login-card">
        <!-- Lado izquierdo (imagen / texto) -->
        <div class="col-md-5 login-image-side d-flex flex-column justify-content-center align-items-center p-4">
            <h2 class="mb-2 text-center">Los Patitos CR</h2>
            <p class="mb-0 text-center">
                Sistema de gestión para tiquetes de soporte.
            </p>
        </div>

    
        <div class="col-md-7 form-side">
            <div class="text-center mb-4">
                <!-- <img src="images/logo.png" alt="Logo" style="max-width:130px;" class="mb-3"> -->
                <h3 class="mb-1">Iniciar sesión</h3>
                <p class="text-muted mb-0">Ingrese sus credenciales</p>
            </div>

           
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger text-center">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
        

            <form method="POST" action="login.php" autocomplete="off">
                <div class="mb-3">
                    <label for="username" class="form-label fw-semibold">Nombre de usuario</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        class="form-control"
                        placeholder="Username"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Contraseña</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        placeholder="••••••••"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-2">
                    Entrar
                </button>
            </form>

            <p class="text-center mt-4 mb-1 text-muted">
                ¿Necesita una cuenta?
            </p>
            <p class="text-center mb-0">
                Contacte al <span class="fw-semibold">superadministrador del sistema</span>.
            </p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
