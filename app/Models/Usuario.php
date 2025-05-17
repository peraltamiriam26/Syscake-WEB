<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    /**
    * Get custom attributes for validator errors.
    *
    * @return array
    */
    public function attributes()
    {
        return [
            'email' => 'email address',
        ];
    }


}
