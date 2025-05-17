<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository
{
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



    public function getUser($id)
    {
        return User::find($id);
    }

    public function createUser($data)
    {
        return User::create($data);
    }

    public function updateUser($id, $data)
    {
        $user = User::find($id);
        $user->update($data);
        return $user;
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
        return $user;
    }

    public function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }


    public function findByNIK($nik)
    {
        return User::where('nik', $nik)->first();
    }

    public function getAllUsersDetail($filters = [])
    {

        $query = DB::table('users')
        ->leftJoin('user_details', 'user_details.user_id', '=', 'users.id')
        ->select("users.id", "users.nik", "users.role", "user_details.name", "user_details.phone_number", "user_details.gender", "user_details.quota", "users.created_at", "users.updated_at");

        return $query->get();

    }


    public function getAllUsersDetailByID($id)
    {

        $query = DB::table('users')
        ->leftJoin('user_details', 'user_details.user_id', '=', 'users.id')
        ->select("users.id", "users.nik", "users.role", "user_details.name", "user_details.phone_number", "user_details.gender", "user_details.quota", "users.created_at", "users.updated_at")
        ->where("users.id", $id);

        return $query->first();
    }

    public function getAllDocterDetail($filters = [])
    {

        $query = DB::table('users')
        ->leftJoin('user_details', 'user_details.user_id', '=', 'users.id')
        ->select("users.id", "users.nik", "users.role", "user_details.name", "user_details.phone_number", "user_details.gender", "user_details.quota", "users.created_at", "users.updated_at");

        if (!empty($filters['role'])) {
            $query->where("users.role", $filters['role']);
        }

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%'. $filters['search']. '%')
                  ->orWhere('phone_number', 'like', '%'. $filters['search']. '%');
            });
        }

        return $query->get();
    }

    public function getAllDocterDetailByID($id)
    {

        $query = DB::table('users')
        ->leftJoin('user_details', 'user_details.user_id', '=', 'users.id')
        ->select("users.id", "users.nik", "users.role", "user_details.name", "user_details.phone_number", "user_details.gender", "user_details.quota", "users.created_at", "users.updated_at")
        ->where("users.role", "docter")
        ->where("users.id", $id);

        return $query->first();
    }



}