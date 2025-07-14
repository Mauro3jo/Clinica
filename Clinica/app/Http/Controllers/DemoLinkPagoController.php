<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DemoLinkPagoController extends Controller
{
    // Coloca tus credenciales de sandbox cuando las tengas
    private $guid = 'TU_GUID_SANDBOX';
    private $frase = 'TU_FRASE_SANDBOX';

    public function pagar(Request $req)
    {
        // 1. Autenticación - obtener JWT
        $auth = Http::post('https://sandboxpp.asjservicios.com.ar:8082/v1/sesion', [
            'guid' => $this->guid,
            'frase' => $this->frase
        ]);
        if (!$auth->ok()) {
            return response()->json(['error' => 'No se pudo autenticar con Click de Pago', 'data' => $auth->json()], 400);
        }
        $token = $auth->json('data');

        // 2. Crear token de pago
        $transId = 'demo' . time();
        $tokenPago = Http::withToken($token)->post('https://sandboxpp.asjservicios.com.ar:8082/v1/tokens', [
            'Comercio' => $this->guid,
            'TotalOperacion' => $req->amount,
            'TransaccionComercioId' => $transId,
            'Ip' => $req->ip()
        ]);
        if (!$tokenPago->ok()) {
            return response()->json(['error' => 'No se pudo obtener token de pago', 'data' => $tokenPago->json()], 400);
        }
        $tokenDePago = $tokenPago->json('data');

        // 3. Ejecutar pago
        $exp = explode('/', $req->expiry);
        $mes = $exp[0] ?? '01';
        $anio = $exp[1] ?? '30';

        $pago = Http::withToken($token)
            ->withHeaders(['X-Token' => $tokenDePago])
            ->post('https://sandboxpp.asjservicios.com.ar:8082/v1/payment', [
                'DatosTarjeta' => [
                    'NumeroTarjeta' => $req->cardNumber,
                    'MesVencimiento' => $mes,
                    'AñoVencimiento' => $anio,
                    'CodigoTarjeta' => $req->cvv,
                    'TitularTarjeta' => $req->holder,
                    'DocumentoTitular' => $req->document,
                    'Email' => 'demo@demo.com',
                    'FechaNacimientoTitular' => '01011980',
                    'NumeroPuertaResumen' => '100',
                    'TipoDocumento' => 'DNI'
                ],
                'CantidadCuotas' => 1,
                'MedioPagoId' => 4,
                'IPCliente' => $req->ip(),
                'AceptTerminosyCondiciones' => true
            ]);
        return $pago->body(); // Devuelve la respuesta cruda (JSON o error)
    }
}
