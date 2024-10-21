<?php

namespace App\Services\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;


/**
 * Interface IArticleService
 *
 * @package App\Services\Contracts
 * @author    Engineer Saud <engr.saud94@gmail.com>
 * @copyright 2024 Techverx.com All rights reserved.
 * @since     Oct 21, 2024
 * @project   news-aggregator
 */
interface IArticleService extends IService
{
    /**
     * Function findAll
     *
     * @param Request $request
     * @param bool $isPaginated
     *
     * @return Collection|LengthAwarePaginator|array
     */
    public function findAll(Request $request, bool $isPaginated = true): Collection|LengthAwarePaginator|array;


    /**
     * Function findById
     *
     * @param int $id
     *
     * @return array|null
     */
    public function findById(int $id): ?array;


    /**
     * Function findByPreferences
     *
     * @param array $sourceIds
     * @param array $categoryIds
     * @param array $authors
     *
     * @return Collection|LengthAwarePaginator|array
     */
    public function findByPreferences(array $sourceIds = [], array $categoryIds = [], array $authors = []): Collection|LengthAwarePaginator|array;
}//end interface
