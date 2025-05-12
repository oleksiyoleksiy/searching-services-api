<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyAvailability extends Model
{
    protected $table = 'company_availabilities';

    protected $fillable = [
        'company_id',
        'day',
        'start',
        'end'
    ];
}
