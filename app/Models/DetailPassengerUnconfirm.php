<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPassengerUnconfirm extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'first_name',
        'last_name',
        'nationality',
        'date_of_birth',
        'passport_number',
        'passport_issued_country',
        'passport_expiry_date',
        'city',
        'country_of_residence',
        'email',
        'country_code_phone',
        'phone',
        'country_code_travel',
        'phone_travel',
        'document_path',
    ];
}
