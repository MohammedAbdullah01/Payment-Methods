<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = ['name',    'slug',    'description',    'status',    'options'];

    protected $casts = [
        'options' => 'json'
    ];

    public function scopeActive(Builder $builder)
    {
        return $builder->where('status' , 'active');
    }

    public function enable()
    {
        $this->update([
            'status' => 'active'
        ]);

    }


    public function desable()
    {
        $this->update([
            'status' => 'inactive'
        ]);
    }


    public function getEnableAttribute()
    {
        return $this->status === 'active';
    }
}
