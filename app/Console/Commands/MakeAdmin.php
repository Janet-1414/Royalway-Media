<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-admin {email : The email address of the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grant admin access to a user (creates user if not found)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = $this->argument('email');

        $user = User::where('email', $email)->first();

        if ($user) {
            if ($user->is_admin) {
                $this->info("User {$email} is already an admin.");
                return self::SUCCESS;
            }

            $user->update(['is_admin' => true]);
            $this->info("Admin access granted to {$email}.");
            return self::SUCCESS;
        }

        // User not found, create new admin user
        $this->info("User {$email} not found. Creating new admin user...");

        $name = $this->ask('Enter the user name');
        $password = $this->secret('Enter the password');

        if (empty($password)) {
            $this->error('Password cannot be empty.');
            return self::FAILURE;
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'is_admin' => true,
        ]);

        $this->info("Admin user {$email} created successfully.");
        return self::SUCCESS;
    }
}
