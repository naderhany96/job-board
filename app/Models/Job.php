<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'company_name', 'salary_min', 'salary_max', 'is_remote', 'job_type', 'status', 'published_at'];


    const FULL_TIME = 'full-time';
    const PART_TIME = 'part-time';
    const CONTRACT  = 'contract';
    const FREELANCE = 'freelance';
    const TYPES = [self::FULL_TIME, self::PART_TIME, self::CONTRACT, self::FREELANCE];


    const DRAFT = 'draft';
    const PUBLISHED  = 'published';
    const ARCHIVED = 'archived';
    const STATUSES = [self::DRAFT, self::PUBLISHED, self::ARCHIVED];

    public function scopeFilter($query, $filters)
    {
        if (isset($filters['title'])) {
            $query->where('title', 'LIKE', "%{$filters['title']}%");
        }

        if (isset($filters['salary_min'])) {
            $query->where('salary_min', '>=', $filters['salary_min']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
    }



    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class);
    }

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_job');
    }


    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'job_attribute_values')
            ->withPivot('value');
    }

    public function attributeValues(): HasMany
    {
        return $this->hasMany(JobAttributeValue::class);
    }
}
