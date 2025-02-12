<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = 'invoices';
    protected $keyType = 'string'; 
    public $incrementing = false;  
    protected $fillable = [
        'id', 
        'user_id', 
        'home_address', 
        'postal_code', 
        'items', 
        'total_price'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
