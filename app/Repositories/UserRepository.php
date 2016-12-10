<?php

namespace App\Repositories;
use Illuminate\Support\Facades\Hash;

/**
 * Description of UserRepository
 *
 * @author Melissa Delgado
 */
class UserRepository extends EloquentRepository {

    protected $model = "App\Models\User";

    public function update($user, $attributes = []) {

        if (isset($attributes['password'])) {
            $attributes['password'] = Hash::make($attributes['password']);
        }

        return $user->update($attributes);
    }

}