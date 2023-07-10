<?php

namespace App\Models;

use App\Models\Promoter;
use App\Models\Amortization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function promoter()
    {
        return $this->hasOne(Promoter::class);
    }

    public function amortizations()
    {
        return $this->hasMany(Amortization::class);
    }
}
