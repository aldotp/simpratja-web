<?php

namespace App\Repositories;

use App\Models\UserDetail;
use Illuminate\Support\Facades\DB;

class UserDetailRepository
{
    /**
     * Retrieve all user details.
     * @param {Object} filters - The filters to apply.
     * @returns {Array<UserDetail>} List of all user details.
     */
    public function getAll($filters = [])
    {
        $query = UserDetail::query();

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('phone_number', 'like', '%' . $filters['search'] . '%');
            });
        }

        return $query->get();
    }

    /**
     * Retrieve user detail by ID.
     * @param {number} id - The ID of the user detail.
     * @returns {UserDetail|null} The user detail instance or null if not found.
     */
    public function getById($id)
    {
        return UserDetail::find($id);
    }

    /**
     * Retrieve user detail by user ID.
     * @param {number} userId - The ID of the user.
     * @returns {UserDetail|null} The user detail instance or null if not found.
     */
    public function getByUserId($userId)
    {
         return UserDetail::query()->where('user_id', $userId)->first();
    }

    /**
     * Store user detail data.
     * @param {Object} data - The user detail data to store.
     * @returns {UserDetail} The created user detail instance.
     */
    public function store($data)
    {
        return UserDetail::create($data);
    }

    /**
     * Update user detail by ID.
     * @param {number} id - The ID of the user detail.
     * @param {Object} data - The data to update.
     * @returns {UserDetail|null} The updated user detail instance or null if not found.
     */
    public function update($id, $data)
    {
        $docter = UserDetail::find($id);
        if (!$docter) {
            return null;
        }
        $docter->update($data);
        return $docter;
    }

    /**
     * Delete user detail by ID.
     * @param {number} id - The ID of the user detail.
     * @returns {UserDetail|null} The deleted user detail instance or null if not found.
     */
    public function delete($id)
    {
        $userDetail = UserDetail::find($id);
        if (!$userDetail) {
            return null;
        }
        $userDetail->delete();
        return $userDetail;
    }
}
