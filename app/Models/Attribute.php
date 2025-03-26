<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\JobAttributeValue;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'options'];

    const TEXT  = 'text';
    const NUMBER  = 'number';
    const BOOLEAN  = 'boolean';
    const DATE  = 'date';
    const SELECT  = 'select';

    const TYPES = [self::TEXT, self::NUMBER, self::BOOLEAN, self::DATE, self::SELECT];


    protected $casts = [
        'options' => 'array', 
    ];

    public function attributeValues() : HasMany
    {
        return $this->hasMany(JobAttributeValue::class);
    }
}
