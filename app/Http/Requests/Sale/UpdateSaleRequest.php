<?php

namespace App\Http\Requests\Sale;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Datos básicos de la venta (opcionales)
            'customer_name' => 'sometimes|nullable|string|max:100',

            // Detalles de la venta (opcionales, pero si se envían deben ser válidos)
            'details' => 'sometimes|array|min:1',
            'details.*.dish_id' => 'sometimes|exists:dishes,id',
            'details.*.drink_id' => 'sometimes|exists:drinks,id',
            'details.*.appetizer_id' => 'sometimes|exists:appetizers,id',
            'details.*.quantity' => 'required_with:details|integer|min:1',
            'details.*.unit_price' => 'required_with:details|numeric|min:0',
            'details.*.notes' => 'sometimes|nullable|string|max:255',

            // Pagos (opcionales, pero si se envían deben ser válidos)
            'payments' => 'sometimes|array|min:1',
            'payments.*.payment_method_id' => 'required_with:payments|exists:payment_methods,id',
            'payments.*.amount' => 'required_with:payments|numeric|min:0.01',
            'payments.*.notes' => 'sometimes|nullable|string|max:255',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $data = $this->validated();

            // Validar que cada detalle tenga al menos un producto
            if (isset($data['details'])) {
                foreach ($data['details'] as $index => $detail) {
                    $hasProduct = isset($detail['dish_id']) ||
                                 isset($detail['drink_id']) ||
                                 isset($detail['appetizer_id']);

                    if (!$hasProduct) {
                        $validator->errors()->add(
                            "details.{$index}",
                            'Cada detalle debe tener al menos un producto (dish_id, drink_id o appetizer_id)'
                        );
                    }
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'customer_name.string' => 'El nombre del cliente debe ser un texto válido',
            'customer_name.max' => 'El nombre del cliente no puede exceder 100 caracteres',

            'details.array' => 'Los detalles deben ser un array',
            'details.min' => 'Debe incluir al menos un detalle de producto',
            'details.*.dish_id.exists' => 'El plato seleccionado no existe',
            'details.*.drink_id.exists' => 'La bebida seleccionada no existe',
            'details.*.appetizer_id.exists' => 'El aperitivo seleccionado no existe',
            'details.*.quantity.required_with' => 'La cantidad es requerida',
            'details.*.quantity.integer' => 'La cantidad debe ser un número entero',
            'details.*.quantity.min' => 'La cantidad debe ser mayor a 0',
            'details.*.unit_price.required_with' => 'El precio unitario es requerido',
            'details.*.unit_price.numeric' => 'El precio unitario debe ser numérico',
            'details.*.unit_price.min' => 'El precio unitario no puede ser negativo',

            'payments.array' => 'Los pagos deben ser un array',
            'payments.min' => 'Debe incluir al menos un pago',
            'payments.*.payment_method_id.required_with' => 'El método de pago es requerido',
            'payments.*.payment_method_id.exists' => 'El método de pago seleccionado no existe',
            'payments.*.amount.required_with' => 'El monto del pago es requerido',
            'payments.*.amount.numeric' => 'El monto del pago debe ser numérico',
            'payments.*.amount.min' => 'El monto del pago debe ser mayor a 0',
        ];
    }
}
