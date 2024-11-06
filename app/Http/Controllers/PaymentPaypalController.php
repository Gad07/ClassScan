<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentPaypalController extends Controller
{
    private $clientId;
    private $secret;
    private $baseURL;

    public function __construct()
    {
        // Usa config directamente con el acceso de configuración simplificado
        $this->baseURL = config('app.env') == 'local' 
            ? 'https://api-m.sandbox.paypal.com' 
            : 'https://api-m.paypal.com';
        $this->clientId = config('app.paypal_id');
        $this->secret = config('app.paypal_secret');
    }

    // Muestra la vista del pago
    public function paypal()
    {
        return view('paypal');
    }

    // Procesa la orden en PayPal
    public function paypalProcessOrder(string $order)
    {
        try {
            $accessToken = $this->getAccessToken();

            $response = Http::acceptJson()
                ->withToken($accessToken)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post("{$this->baseURL}/v2/checkout/orders/{$order}/capture")
                ->json();

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error en la captura de la orden de PayPal: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error procesando la orden de PayPal.'], 500);
        }
    }

    // Procesa el éxito del pago y actualiza al usuario autenticado
    public function paymentSuccess(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $subscriptionType = $request->input('subscriptionType'); // Opcional

            $user->pago = 1;
            $user->rol = 'profesor';
            $user->save();

            return response()->json(['success' => true, 'message' => 'Usuario actualizado correctamente.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Usuario no autenticado.'], 401);
        }
    }

    // Obtiene el token de acceso de PayPal
    private function getAccessToken()
    {
        $response = Http::asForm()
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/x-www-form-urlencoded'
            ])
            ->withBasicAuth($this->clientId, $this->secret)
            ->post("{$this->baseURL}/v1/oauth2/token", [
                'grant_type' => 'client_credentials'
            ])->json();

        // Maneja potenciales errores en la obtención del token
        if (!isset($response['access_token'])) {
            Log::error('No se pudo obtener el token de acceso de PayPal.');
            throw new \Exception('Error obteniendo el token de acceso de PayPal.');
        }

        return $response['access_token'];
    }
}
