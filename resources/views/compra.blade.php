<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Compra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
    <a href="{{ url('/') }}" class="btn btn-outline-primary m-3 d-inline-flex align-items-center">
    <i class="bi bi-arrow-left me-2"></i> Volver al inicio
</a>

<div class="container py-3">
    <h1 class="mb-4 text-center">Realiza tu compra</h1>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('procesar.compra') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Identificación</label>
                    <input type="text" name="identificacion" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Producto</label>
                    <input type="text" name="producto" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Monto (COP)</label>
                    <input type="number" name="monto" class="form-control" required>
                </div>

                <div class="col-12 d-flex gap-3 mt-3">
                    <button type="submit" name="pago" value="pse" class="btn btn-outline-primary w-50">
                        <i class="bi bi-credit-card-2-front-fill me-2"></i> Pagar con PSE (SOAP)
                    </button>
                    <button type="submit" name="pago" value="bancolombia" class="btn btn-outline-success w-50">
                        <i class="bi bi-bank2 me-2"></i> Pagar con Bancolombia (REST)
                    </button>
                </div>
            </form>
        </div>
    </div>

    @isset($respuesta_pago)
        <div class="card shadow mt-5">
            <div class="card-header bg-dark text-white">
                Resultado del Pago
            </div>
            <div class="card-body">
                @if(isset($respuesta_pago['error']))
                    <div class="alert alert-danger">
                        <strong>Error:</strong> {{ $respuesta_pago['error'] }}
                    </div>

                    @if(isset($respuesta_pago['body']))
                        <pre class="bg-light p-3 border rounded">{{ $respuesta_pago['body'] }}</pre>
                    @endif

                    @if(isset($respuesta_pago['payload_enviado']))
                        <p class="mt-3"><strong>Payload enviado:</strong></p>
                        <pre class="bg-light p-3 border rounded">{{ json_encode($respuesta_pago['payload_enviado'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    @endif
                @else
                    <div class="alert alert-success">
                        <strong>Código:</strong> {{ $respuesta_pago['codigoError'] ?? 'Desconocido' }}<br>
                        <strong>Mensaje:</strong> {{ $respuesta_pago['descripcionError'] ?? 'Sin mensaje' }}
                    </div>

                    @if(isset($respuesta_pago['urlRedireccion']))
                        <a class="btn btn-outline-primary" target="_blank" href="{{ $respuesta_pago['urlRedireccion'] }}">
                            <i class="bi bi-box-arrow-up-right"></i> Ir al pago
                        </a>
                    @endif
                @endif
            </div>
        </div>
    @endisset
</div>
</body>

</html>