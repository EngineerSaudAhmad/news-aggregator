<?php

namespace App\Services;


use App\Services\Contracts\IService;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseService
 *
 * @package   App\Services
 * @author    Engineer Saud <engr.saud94@gmail.com>
 * @copyright 2024 All rights reserved.
 * @since     Oct 20, 2024
 * @project   news-aggregator
 */
abstract class BaseService implements IService
{

    /**
     * Property model
     *
     * @var Model
     */
    protected Model $model;
}//end class
