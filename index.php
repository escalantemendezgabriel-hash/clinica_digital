<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clínica Dental — Sistema de Gestión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 50%, #084298 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .hero {
            flex: 1;
            display: flex;
            align-items: center;
            padding: 3rem 0;
        }

        .card-feature {
            border: none;
            border-radius: 12px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-feature:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        .icon-box {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            margin-bottom: 1rem;
        }

        .btn-login {
            font-size: 1.1rem;
            padding: 0.75rem 2.5rem;
            border-radius: 50px;
            font-weight: 600;
            letter-spacing: 0.03em;
        }

        footer {
            background: rgba(0, 0, 0, 0.2);
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85rem;
        }
    </style>
</head>
<body>

    <!-- Navbar mínima -->
    <nav class="navbar navbar-dark px-4 py-3">
        <span class="navbar-brand fw-bold fs-5">🦷 Clínica Dental</span>
        <a href="login.php" class="btn btn-outline-light btn-sm">Iniciar sesión</a>
    </nav>

    <!-- Hero -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center g-5">

                <!-- Texto principal -->
                <div class="col-lg-6 text-white">
                    <h1 class="display-5 fw-bold mb-3">
                        Sistema de Gestión<br>Odontológica
                    </h1>
                    <p class="lead mb-4 text-white-50">
                        Administra pacientes, historias clínicas y procedimientos
                        desde un solo lugar. Rápido, seguro y sin complicaciones.
                    </p>
                    <a href="login.php" class="btn btn-light btn-login text-primary shadow">
                        Entrar al sistema →
                    </a>
                </div>

                <!-- Cards de características -->
                <div class="col-lg-6">
                    <div class="row g-3">

                        <div class="col-sm-6">
                            <div class="card card-feature h-100 p-3">
                                <div class="icon-box bg-primary bg-opacity-10">👤</div>
                                <h6 class="fw-bold mb-1">Pacientes</h6>
                                <p class="text-muted small mb-0">
                                    Registra y consulta la información completa de cada paciente.
                                </p>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="card card-feature h-100 p-3">
                                <div class="icon-box bg-success bg-opacity-10">📋</div>
                                <h6 class="fw-bold mb-1">Historia clínica</h6>
                                <p class="text-muted small mb-0">
                                    Lleva el historial completo de atenciones por paciente.
                                </p>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="card card-feature h-100 p-3">
                                <div class="icon-box bg-warning bg-opacity-10">🦷</div>
                                <h6 class="fw-bold mb-1">Procedimientos</h6>
                                <p class="text-muted small mb-0">
                                    Gestiona el catálogo de procedimientos y sus precios.
                                </p>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="card card-feature h-100 p-3">
                                <div class="icon-box bg-danger bg-opacity-10">📄</div>
                                <h6 class="fw-bold mb-1">Exportar PDF</h6>
                                <p class="text-muted small mb-0">
                                    Genera la historia clínica en PDF con un solo clic.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center py-3">
        <div class="container">
            &copy; <?= date('Y') ?> Clínica Dental — Sistema de Historia Clínica Odontológica
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
