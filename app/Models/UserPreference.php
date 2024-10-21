<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * Class UserPreference
 *
 * @package   App\Models
 * @author    Engineer Saud <engr.saud94@gmail.com>
 * @copyright 2024 All rights reserved.
 * @since     Oct 21, 2024
 * @project   news-aggregator
 *
 * @var int      $id
 * @var int      $user_id
 * @var int      $source_id
 * @var int      $category_id
 * @var string   $author
 * @var Carbon   $created_at
 * @var Carbon   $updated_at
 * @var User     $user
 * @var Source   $source
 * @var Category $category
 */
class UserPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'source_id',
        'category_id',
        'author'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }//end user()

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }//end category()

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }//end source()
}//end class
