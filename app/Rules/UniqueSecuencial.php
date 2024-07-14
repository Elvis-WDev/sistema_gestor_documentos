<?php

namespace App\Rules;

use App\Models\Factura;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueSecuencial implements ValidationRule
{
    protected $establecimiento_id;
    protected $punto_emision_id;
    protected $ignoreId;

    public function __construct($establecimiento_id, $punto_emision_id, $ignoreId = null)
    {
        $this->establecimiento_id = $establecimiento_id;
        $this->punto_emision_id = $punto_emision_id;
        $this->ignoreId = $ignoreId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = Factura::where('establecimiento_id', $this->establecimiento_id)
            ->where('punto_emision_id', $this->punto_emision_id)
            ->where('secuencial', $value);

        if ($this->ignoreId) {
            $query->where('id_factura', '<>', $this->ignoreId);
        }

        if ($query->exists()) {
            $fail('El secuencial debe ser único para la combinación de establecimiento y punto de emisión.');
        }
    }
}
