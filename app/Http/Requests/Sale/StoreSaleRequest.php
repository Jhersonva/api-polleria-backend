<?php

namespace App\Http\Requests\Sale;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreSaleRequest extends FormRequest
{
    /**
     * Determinar si el usuario está autorizado para realizar esta petición
     */
    public function authorize(): bool
    {
        return true; // Para pollería, asumimos autorización básica
    }

    /**
     * Obtener las reglas de validación
     */
    public function rules(): array
    {
        return [
            'customer_name' => 'nullable|string|max:100',

            // Validación de detalles de venta
            'details' => 'required|array|min:1',
            'details.*.dish_id' => 'nullable|exists:dishes,id',
            'details.*.drink_id' => 'nullable|exists:drinks,id',
            'details.*.appetizer_id' => 'nullable|exists:appetizers,id',
            'details.*.quantity' => 'required|integer|min:1',
            'details.*.unit_price' => 'required|numeric|min:0',

            // Validación de pagos
            'payments' => 'required|array|min:1',
            'payments.*.payment_method_id' => 'required|exists:payment_methods,id',
            'payments.*.amount' => 'required|numeric|min:0.01',
            'payments.*.notes' => 'nullable|string|max:255'
        ];
    }

    /**
     * Validación adicional personalizada
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            // Validar que cada detalle tenga al menos dish_id, drink_id o appetizer_id
            if ($this->has('details')) {
                foreach ($this->details as $index => $detail) {
                    if (empty($detail['dish_id']) && empty($detail['drink_id']) && empty($detail['appetizer_id'])) {
                        $validator->errors()->add(
                            "details.{$index}",
                            'Cada detalle debe tener dish_id, drink_id o appetizer_id'
                        );
                    }
                }
            }

            // Validar que el total de pagos sea positivo
            if ($this->has('payments')) {
                $totalPayments = collect($this->payments)->sum('amount');
                if ($totalPayments <= 0) {
                    $validator->errors()->add('payments', 'El total de pagos debe ser mayor a 0');
                }
            }
        });
    }

    /**
     * Mensajes de error personalizados
     */
    public function messages(): array
    {
        return [
            'customer_name.string' => 'El nombre del cliente debe ser texto',
            'customer_name.max' => 'El nombre del cliente no puede exceder 100 caracteres',

            'details.required' => 'Los detalles de la venta son requeridos',
            'details.array' => 'Los detalles deben ser un arreglo',
            'details.min' => 'Debe incluir al menos un detalle de venta',

            'details.*.dish_id.exists' => 'El plato seleccionado no existe',
            'details.*.drink_id.exists' => 'La bebida seleccionada no existe',
            'details.*.appetizer_id.exists' => 'El aperitivo seleccionado no existe',
            'details.*.quantity.required' => 'La cantidad es requerida',
            'details.*.quantity.integer' => 'La cantidad debe ser un número entero',
            'details.*.quantity.min' => 'La cantidad debe ser al menos 1',
            'details.*.unit_price.required' => 'El precio unitario es requerido',
            'details.*.unit_price.numeric' => 'El precio unitario debe ser numérico',
            'details.*.unit_price.min' => 'El precio unitario no puede ser negativo',

            'payments.required' => 'Los pagos son requeridos',
            'payments.array' => 'Los pagos deben ser un arreglo',
            'payments.min' => 'Debe incluir al menos un método de pago',

            'payments.*.payment_method_id.required' => 'El método de pago es requerido',
            'payments.*.payment_method_id.exists' => 'El método de pago no existe',
            'payments.*.amount.required' => 'El monto del pago es requerido',
            'payments.*.amount.numeric' => 'El monto del pago debe ser numérico',
            'payments.*.amount.min' => 'El monto del pago debe ser mayor a 0',
            'payments.*.notes.string' => 'Las notas deben ser texto',
            'payments.*.notes.max' => 'Las notas no pueden exceder 255 caracteres'
        ];
    }

    /**
     * Manejar validación fallida
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Datos de entrada inválidos',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}
