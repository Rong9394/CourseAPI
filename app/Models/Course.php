<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property $title
 * @property $description
 * @property $price_in_cents_usd
 * @property $instructor_id
 * @property $created_at
 * @property $updated_at
 */
class Course extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'price_in_cents_usd'];
}
