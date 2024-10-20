<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * Class Category
 *
 * @package App\Models
 * @author    Engineer Saud <engr.saud94@gmail.com>
 * @copyright 2024 All rights reserved.
 * @since     Oct 21, 2024
 * @project   news-aggregator
 *
 * @var int                  id
 * @var string               name
 * @var Carbon               created_at
 * @var Carbon               updated_at
 * @var Collection|Article[] articles
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];


    /**
     * Function articles
     *
     * @return HasMany
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }//end articles
}//end class
