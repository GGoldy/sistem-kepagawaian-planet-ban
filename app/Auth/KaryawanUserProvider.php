<?php

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class KaryawanUserProvider extends EloquentUserProvider
{
    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials)) return;

        $query = $this->createModel()->newQuery();

        foreach ($credentials as $key => $value) {
            if (!str_contains($key, 'password')) {
                // Look into the related karyawan's email
                $query->whereHas('karyawan', function ($q) use ($value) {
                    $q->where('email', $value);
                });
            }
        }

        return $query->first();
    }
}
