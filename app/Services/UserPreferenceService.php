<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserPreference;
use App\Services\Contracts\IUserPreferenceService;
use Illuminate\Database\Eloquent\Collection;
use Throwable;


/**
 * Class UserPreferenceService
 *
 * @package   App\Services
 * @author    Engineer Saud <engr.saud94@gmail.com>
 * @copyright 2024 All rights reserved.
 * @since     Oct 21, 2024
 * @project   news-aggregator
 */
class UserPreferenceService extends BaseService implements IUserPreferenceService
{


    /**
     * UserPreferenceService constructor.
     */
    public function __construct(UserPreference $userPreference)
    {
        $this->model = $userPreference;
    }//end __construct()


    /**
     * @inheritdoc
     */
    public function getUserPreferences(User $user): Collection|array
    {
        try {
            return $user->preferences()->with(['source', 'category'])->get();
        } catch (Throwable $e) {
            report($e);
        }

        return [];
    }//end getUserPreferences()


    /**
     * @inheritdoc
     */
    public function feedUserPreference(User $user, array $data): ?UserPreference
    {
        try {
            return $user->preferences()->updateOrCreate($data, $data);
        } catch (Throwable $e) {
            report($e);
        }
        return null;
    }//end feedUserPreference()
}//end class
