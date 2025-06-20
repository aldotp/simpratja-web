<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    /**
     * Retrieve all users with optional filters.
     * @param {Object} filters - The filters to apply.
     * @returns {Array<User>} List of all users.
     */
    public function getAllUsers($filters = [])
    {
        $query = User::query();

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('nik', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('role', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (!empty($filters['role'])) {
            $query->where('role', $filters['role']);
        }

        return $query->get();
    }

    /**
     * Retrieve user by ID.
     * @param {number} id - The ID of the user.
     * @returns {User|null} The user instance or null if not found.
     */
    public function getUser($id)
    {
        return User::find($id);
    }

    /**
     * Store user data.
     * @param {Object} data - The user data to store.
     * @returns {User} The created user instance.
     */
    public function createUser($data)
    {
        return User::create($data);
    }

    /**
     * Update user by ID.
     * @param {number} id - The ID of the user.
     * @param {Object} data - The data to update.
     * @returns {User|null} The updated user instance or null if not found.
     */
    public function updateUser($id, $data)
    {
        $user = User::find($id);
        $user->update($data);
        return $user;
    }

    /**
     * Delete user by ID.
     * @param {number} id - The ID of the user.
     * @returns {boolean} True if the user was deleted, false otherwise.
     */
    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
        return $user;
    }

    /**
     * Find user by email.
     * @param {string} email - The email of the user.
     * @returns {User|null} The user instance or null if not found.
     */
    public function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    /**
     * Find user by NIK.
     * @param {string} nik - The NIK of the user.
     * @returns {User|null} The user instance or null if not found.
     */
    public function findByNIK($nik)
    {
        return User::where('nik', $nik)->first();
    }

    /**
     * Find user where role not docter.
     * @returns {User|null} The user instance or null if not found.
     */
    public function getAllUsersDetail($filters = [])
    {


       $user = User::whereNot('role', 'docter')->get();

        return $user;

    }

    /**
     * Get all users detail by id.
     * @param {number} id - The ID of the user.
     * @returns {User|null} The user instance or null if not found.
     */
    public function getAllUsersDetailByID($id)
    {

        $query = DB::table('users')
        ->leftJoin('user_details', 'user_details.user_id', '=', 'users.id')
        ->select("users.id", "users.nik", "users.role", "user_details.name", "user_details.phone_number", "user_details.gender", "user_details.quota", "users.created_at", "users.updated_at")
        ->where("users.id", $id);

        return $query->first();
    }

    /**
     * Get all docter detail by id.
     * @param {number} id - The ID of the user.
     * @returns {User|null} The user instance or null if not found.
     */
    public function getAllDocterDetail(array $filters = [])
    {
        $date = $filters['date'] ?? date('Y-m-d');
        $search = $filters['search'] ?? null;
        $role = $filters['role'] ?? 'doctor'; // default: hanya role doctor

        $query = DB::table('users')
            ->leftJoin('user_details', 'user_details.user_id', '=', 'users.id')
            ->leftJoin('visits', function ($join) use ($date) {
                $join->on('visits.docter_id', '=', 'users.id')
                    ->whereDate('visits.examination_date', '=', $date)
                    ->where('visits.queue_number', '!=', 0);
            })
            ->select(
                'users.id',
                'users.nik',
                'users.role',
                'user_details.name',
                'user_details.phone_number',
                'user_details.gender',
                'user_details.quota',
                'users.created_at',
                'users.updated_at',
                DB::raw('COUNT(visits.id) as visit_count')
            )
            ->where('users.role', $role)
            ->groupBy(
                'users.id',
                'users.nik',
                'users.role',
                'user_details.name',
                'user_details.phone_number',
                'user_details.gender',
                'user_details.quota',
                'users.created_at',
                'users.updated_at'
            )
            ->havingRaw('visit_count < user_details.quota');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('user_details.name', 'like', '%' . $search . '%')
                ->orWhere('user_details.phone_number', 'like', '%' . $search . '%');
            });
        }

        return $query->get();
    }


    /**
     * Get all docter detail by id.
     * @param {number} id - The ID of the user.
     * @returns {User|null} The user instance or null if not found.
     */
    public function getAllDocterDetailByID($id)
    {

        $query = DB::table('users')
        ->leftJoin('user_details', 'user_details.user_id', '=', 'users.id')
        ->select("users.id", "users.nik", "users.role", "user_details.name", "user_details.phone_number", "user_details.gender", "user_details.quota", "users.created_at", "users.updated_at")
        ->where("users.role", "docter")
        ->where("users.id", $id);

        return $query->first();
    }


    public function query(){
        return User::query();
    }


}
