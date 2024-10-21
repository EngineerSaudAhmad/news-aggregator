<?php

namespace App\Services\Contracts;


use App\Models\User;
use App\Models\UserPreference;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

/**
 * Interface IUserPreferenceService
 *
 * @package   App\Services\Contracts
 * @author    Engineer Saud <engr.saud94@gmail.com>
 * @copyright 2024 Techverx.com All rights reserved.
 * @since     Oct 21, 2024
 * @project   news-aggregator
 */
interface IUserPreferenceService extends IService
{


    /**
     * Function getUserPreferences
     *
     * @param Request $request
     *
     * @return array|Collection
     */
    public function getUserPreferences(User $user): Collection|array;


    /**
     * Function feedUserPreference
     *
     * @param User $user
     * @param array $data
     *
     * @return UserPreference|null
     */
    public function feedUserPreference(User $user, array $data): ?UserPreference;
}//end interface
