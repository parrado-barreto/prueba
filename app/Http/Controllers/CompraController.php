<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Configuracion;

class CompraController extends Controller
{
    public function procesar(Request $request)
    {
        $datos = $request->all();
        $respuesta = [];

        if ($request->pago === 'pse') {
            $respuesta = $this->integrarPse($datos);
        } elseif ($request->pago === 'bancolombia') {
            $respuesta = $this->integrarBancolombia($datos);
        }

        return view('compra', [
            'respuesta_pago' => $respuesta
        ]);
    }

    private function integrarPse($datos)
    {
        try {
            $config = Configuracion::first();
            $claveOriginal = $config->clave_original;
            $codEmpresa = $config->cod_empresa;
            $codServicio = $config->cod_servicio;
            $referencia = rand(100000, 999999);
            $valorTotal = $datos['monto'];
            $clave = md5($claveOriginal . $codEmpresa . $referencia . $valorTotal);

            $params = [
                'resumen' => [
                    'clave' => $clave,
                    'codEmpresa' => $codEmpresa,
                    'codServicio' => $codServicio,
                    'descripcionPago' => $datos['producto'] ?? 'Pago desde landing',
                    'email' => $datos['email'],
                    'identificacion' => $datos['identificacion'],
                    'iva' => 0,
                    'nombrePagador' => $datos['nombre'],
                    'referencia' => $referencia,
                    'tipoIdentificacion' => 'CC',
                    'valorTotal' => $valorTotal
                ]
            ];

            $client = new \SoapClient("https://test.abcpagos.com:8443/WsRealtechTransaciones/Transacciones?wsdl");
            $response = $client->__soapCall("InicioPago", [$params]);
            $resultado = $response->return ?? null;

            return [
                'codigoError' => $resultado->codigoError ?? null,
                'descripcionError' => $resultado->descripcionError ?? null,
                'idPago' => $resultado->idPago ?? null,
                'urlRedireccion' => isset($resultado->idPago)
                    ? "https://test.abcpagos.com/PSE/paymentProcessor?id_transaccion=" . $resultado->idPago
                    : null
            ];
        } catch (\Exception $e) {
            return ['error' => 'Error al conectar con el WebService: ' . $e->getMessage()];
        }
    }

    private function integrarBancolombia($datos)
    {
        try {
            $endpoint = "https://test.abcpagos.com/api_transacciones/InicioPago";

            $config = Configuracion::first();
            $claveOriginal = $config->clave_original;
            $codEmpresa = $config->cod_empresa;
            $codServicio = $config->cod_servicio;
            $referencia = time();
            $valorTotal = intval($datos['monto']);
            $clave = md5($claveOriginal . $codEmpresa . $referencia . $valorTotal);

            $payload = [
                "conceptoServicio" => $datos['producto'] ?? "Pago desde landing",
                "codEmpresa" => $codEmpresa,
                "referencia" => $referencia,
                "nombrePagador" => $datos['nombre'],
                "email" => $datos['email'],
                "tipoIdentificacion" => "CC",
                "identificacion" => (string) $datos['identificacion'],
                "iva" => 0,
                "valorTotal" => $valorTotal,
                "descripcionPago" => "Compra prueba REST",
                "codServicio" => $codServicio,
                "clave" => $clave,
                "multicredito" => new \stdClass(),
                "infoAdicional" => "desde Laravel"
            ];

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])->post($endpoint, $payload);

            if ($response->successful()) {
                $data = $response->json();
                $idPago = $data['idPago'] ?? null;

                return [
                    'codigoError' => $data['codigoError'] ?? null,
                    'descripcionError' => $data['descripcionError'] ?? null,
                    'idPago' => $idPago,
                    'urlRedireccion' => $idPago
                        ? "https://test.abcpagos.com/PSE/paymentProcessor?id_transaccion=" . $idPago
                        : null
                ];
            } else {
                return [
                    'error' => 'Respuesta fallida',
                    'payload_enviado' => $payload,
                    'status' => $response->status(),
                    'body' => $response->body()
                ];
            }
        } catch (\Exception $e) {
            return ['error' => 'Error al consumir REST: ' . $e->getMessage()];
        }
    }
}
