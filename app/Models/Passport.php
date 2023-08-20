<?php

namespace App\Models;

use Laravel\Passport\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Passport extends Client
{
    // use HasFactory;
    public function skipsAuthorization()
    {
        // return false;
        return $this->firstParty();
    }
}
