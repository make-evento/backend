<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = ["name", "organization_id"];

    public function items()
    {
        return $this->hasMany(Item::class, "category_id");
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, "organization_id");
    }

    public function supplierItemCategories()
    {
        return $this->hasMany(SupplierItemCategory::class, "item_category_id");
    }
}
