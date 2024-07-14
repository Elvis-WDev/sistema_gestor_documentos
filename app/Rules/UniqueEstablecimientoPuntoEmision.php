<?php

namespace App\Rules;

use App\Models\PuntoEmision;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueEstablecimientoPuntoEmision implements ValidationRule
{
    protected $establecimiento_id;
    protected $ignoreId;

    public function __construct($establecimiento_id, $ignoreId = null)
    {
        $this->establecimiento_id = $establecimiento_id;
        $this->ignoreId = $ignoreId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = PuntoEmision::where('establecimiento_id', $this->establecimiento_id)
            ->where('nombre', $value);

        if ($this->ignoreId) {
            $query->where('id', '<>', $this->ignoreId);
        }

        if ($query->exists()) {
            $fail('La combinación de establecimiento y punto de emisión ya existe.');
        }
    }
}
