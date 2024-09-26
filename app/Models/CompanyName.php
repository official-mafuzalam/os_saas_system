<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyName extends Model
{
    use HasFactory;

    // Explicitly define the table name if necessary (optional)
    protected $table = 'company_names';

    // Add the fillable properties
    protected $fillable = ['name'];
}
