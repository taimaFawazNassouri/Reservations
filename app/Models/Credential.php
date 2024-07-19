<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credential extends Model
{
    use HasFactory;
    protected $fillable = ['user_name','password','user_id'];
    
    public static function getCredentials()
    {
       
        return self::select('user_name', 'password')->first();
    }
    /**
     * Get the user that owns the Reservation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user_verify(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
