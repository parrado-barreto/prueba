<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ClimaController extends Controller
{
    public function form()
    {
        return view('clima');
    }

    public function buscar(Request $request)
    {
        $ciudad = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $request->ciudad));

        $coords = ['bogota' => ['lat' => 4.71, 'lon' => -74.07],
            'villavicencio' => ['lat' => 4.15, 'lon' => -73.64],
            'medellin' => ['lat' => 6.25, 'lon' => -75.56],
            'cali' => ['lat' => 3.44, 'lon' => -76.52],
            'barranquilla' => ['lat' => 10.96, 'lon' => -74.80],
            'cartagena' => ['lat' => 10.42, 'lon' => -75.55],
            'bucaramanga' => ['lat' => 7.13, 'lon' => -73.13],
            'pereira' => ['lat' => 4.81, 'lon' => -75.69],
            'manizales' => ['lat' => 5.07, 'lon' => -75.52],
            'armenia' => ['lat' => 4.53, 'lon' => -75.68],
            'cucuta' => ['lat' => 7.89, 'lon' => -72.50],
            'neiva' => ['lat' => 2.93, 'lon' => -75.28],
            'ibague' => ['lat' => 4.44, 'lon' => -75.24],
            'pasto' => ['lat' => 1.21, 'lon' => -77.28],
            'monteria' => ['lat' => 8.75, 'lon' => -75.88],
            'sincelejo' => ['lat' => 9.30, 'lon' => -75.39]
        ];

        if (!isset($coords[$ciudad])) {
            return response()->json(['error' => 'Ciudad no soportada']);
        }

        $response = Http::get("https://api.open-meteo.com/v1/forecast", [
            'latitude' => $coords[$ciudad]['lat'],
            'longitude' => $coords[$ciudad]['lon'],
            'current_weather' => true
        ]);

        return view('clima', [
            'clima' => $response->json()['current_weather'] ?? null,
            'ciudad' => $ciudad
        ]);
    }
}
