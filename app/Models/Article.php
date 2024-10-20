<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * Class Article
 *
 * @package App\Models
 * @author    Engineer Saud <engr.saud94@gmail.com>
 * @copyright 2024 All rights reserved.
 * @since     Oct 21, 2024
 * @project   news-aggregator
 *
 * @var int      id
 * @var int      source_id
 * @var int      category_id
 * @var string   title
 * @var string   content
 * @var string   author
 * @var Carbon   published_at
 * @var Carbon   created_at
 * @var Carbon   updated_at
 * @var Category category
 * @var Source   source
 */
class Article extends Model
{
    use HasFactory;


    /**
     * Property fillable
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'content',
        'author',
        'published_at',
        'source_id',
        'category_id'
    ];


    /**
     * Property casts
     *
     * @var string[]
     */
    protected $casts = [
        'published_at' => 'datetime',
    ];


    /**
     * Function category
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }//end category()


    /**
     * Function source
     *
     * @return BelongsTo
     */
    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }//end source()
}//end class
