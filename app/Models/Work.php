<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    public function offer_name()
    {
        return $this->belongsTo(OfferName::class);
    }

    // The company name is basically device. But other developer has made it as CompanyName. 
    public function company_name()
    {
        return $this->belongsTo(CompanyName::class);
    }
}
