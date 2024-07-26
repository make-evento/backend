<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        "razao_social",
        "nome_fantasia",
        "document_type",
        "document_number",
        "email",
        "phone",
        "organization_id",
        "address_id",
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class, "organization_id");
    }

    public function address()
    {
        return $this->belongsTo(Address::class, "address_id");
    }

    public function categories()
    {
        return $this->belongsToMany(ItemCategory::class, "supplier_item_categories", "supplier_id", "item_category_id");
    }

    public function bankAccounts()
    {
        return $this->hasMany(SupplierBankAccount::class, "supplier_id");
    }

    public function contacts()
    {
        return $this->hasMany(SupplierContact::class, "supplier_id");
    }
}
