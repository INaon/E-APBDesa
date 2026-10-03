<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetAdminPassword extends Command
{
    protected $signature = 'admin:reset-password';

    protected $description = 'Reset password administrator';

    public function handle(): int
    {
        $user = User::where('username', 'admin')->first();

        if (! $user) {
            $this->error('User dengan username "admin" tidak ditemukan.');

            return self::FAILURE;
        }

        $password = $this->secret('Masukkan password baru');

        if (! $password) {
            $this->error('Password tidak boleh kosong.');

            return self::FAILURE;
        }

        $user->password = Hash::make($password);
        $user->save();

        $this->info('Password administrator berhasil diubah.');

        return self::SUCCESS;
    }
}