<?php

namespace App\Models;

use App\Models\Payment;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Amortization extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
