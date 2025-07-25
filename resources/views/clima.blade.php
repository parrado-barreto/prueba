<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Consulta del Clima</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/clima.css">
</head>

<body>
    <a href="{{ url('/') }}" class="btn btn-outline-primary m-3 d-inline-flex align-items-center">
        <i class="bi bi-arrow-left me-2"></i> Volver al inicio
    </a>

    <div class="container mt-1">
        <div class="card p-4 mx-auto" style="max-width: 500px;">
            <h3 class="text-center mb-4">Consultar Clima por Ciudad</h3>

            <form action="{{ route('clima.buscar') }}" method="GET">
                <div class="mb-3">
                    <label for="ciudad" class="form-label">Selecciona una ciudad</label>
                    <select name="ciudad" class="form-select" required>
                        <option value="">Elige una ciudad</option>
                        <option value="bogota">Bogotá</option>
                        <option value="villavicencio">Villavicencio</option>
                        <option value="medellin">Medellín</option>
                        <option value="cali">Cali</option>
                        <option value="barranquilla">Barranquilla</option>
                        <option value="cartagena">Cartagena</option>
                        <option value="bucaramanga">Bucaramanga</option>
                        <option value="pereira">Pereira</option>
                        <option value="manizales">Manizales</option>
                        <option value="armenia">Armenia</option>
                        <option value="cucuta">Cúcuta</option>
                        <option value="neiva">Neiva</option>
                        <option value="ibague">Ibagué</option>
                        <option value="pasto">Pasto</option>
                        <option value="monteria">Montería</option>
                        <option value="sincelejo">Sincelejo</option>
                    </select>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-clima">🌤 Consultar clima</button>
                </div>
            </form>

            @isset($clima)
                <div class="alert alert-info mt-4">
                    <h5 class="text-center">Clima actual en {{ ucfirst($ciudad) }}</h5>
                    <ul class="list-group list-group-flush mt-2">
                        <li class="list-group-item">
                            🌡 <strong>Temperatura:</strong> {{ $clima['temperature'] }}°C
                        </li>
                        <li class="list-group-item">
                            💨 <strong>Viento:</strong> {{ $clima['windspeed'] }} km/h
                        </li>
                        <li class="list-group-item">
                            🧭 <strong>Dirección del viento:</strong> {{ $clima['winddirection'] }}°
                        </li>
                        <li class="list-group-item">
                            ☀️ <strong>Día:</strong> {{ $clima['is_day'] ? 'Sí' : 'No' }}
                        </li>
                    </ul>
                </div>
            @endisset

            @if (isset($error))
                <div class="alert alert-danger mt-3">
                    <strong>Error:</strong> {{ $error }}
                </div>
            @endif
        </div>
    </div>

</body>

</html>
