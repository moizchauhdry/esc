<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(User::class, 'company_id', 'id');
    }
    
    public function shipper()
    {
        return $this->belongsTo(User::class, 'shipper_id', 'id');
    }
    
    public function consignee()
    {
        return $this->belongsTo(User::class, 'consignee_id', 'id');
    }

    public function uploads()
    {
        return $this->hasMany(InvoiceUpload::class, 'invoice_id', 'id');
    }

    public function getCarrier()
    {
        return $this->belongsTo(Carrier::class, 'carrier_id', 'id');
    }
}
