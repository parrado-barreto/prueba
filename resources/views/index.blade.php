<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio | Prueba Realtech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar decorativo -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <span class="navbar-brand">Realtech - Prueba Técnica</span>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container mt-5">
        <div class="text-center mb-4">
            <h1 class="mb-3">Bienvenido</h1>
            <h4 class="text-muted">¿Qué deseas hacer?</h4>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-5 mb-3">
                <a href="{{ route('clima.form') }}" class="text-decoration-none">
                    <div class="card shadow-sm h-100 hover-shadow">
                        <div class="card-body text-center">
                            <i class="bi bi-cloud-sun-fill fs-1 text-info"></i>
                            <h5 class="card-title mt-3">Consultar clima por ciudad</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-5 mb-3">
                <a href="{{ route('compra.form') }}" class="text-decoration-none">
                    <div class="card shadow-sm h-100 hover-shadow">
                        <div class="card-body text-center">
                            <i class="bi bi-credit-card-2-front-fill fs-1 text-success"></i>
                            <h5 class="card-title mt-3">Realizar una compra</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

</body>
</html>
