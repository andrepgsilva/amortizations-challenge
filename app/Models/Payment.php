<?php

namespace App\Models;

use App\Models\Amortization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function amortization()
    {
        return $this->belongsTo(Amortization::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}
