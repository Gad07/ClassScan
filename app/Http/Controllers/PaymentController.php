<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function showPaymentForm()
    {
        return view('payment.form'); // Retorna la vista del formulario de pago
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'stripeToken' => 'required',
        ]);

        // Configurar la clave secreta de Stripe
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            // Crear el cargo en Stripe
            $charge = Charge::create([
                'amount' => $request->amount * 100, // en centavos (es decir, $1 equivale a 100)
                'currency' => 'usd',
                'description' => 'Pago de servicios',
                'source' => $request->stripeToken,
            ]);

            // Si el pago fue exitoso, redirigir con un mensaje de éxito
            return redirect()->route('payment.form')->with('status', 'Pago realizado correctamente');

        } catch (\Exception $e) {
            // Si ocurre un error durante el pago, registrar el error y mostrar mensaje al usuario
            Log::error('Error durante el pago: ' . $e->getMessage());
            return redirect()->route('payment.form')->withErrors('Ocurrió un problema al procesar el pago. Inténtalo nuevamente.');
        }
    }
}
