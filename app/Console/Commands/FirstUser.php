<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Hash;

class FirstUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make first user to login with';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $count = User::count();
        if ($count != 0) {
            $this->error('A user already exists');
            return;
        }
        $name = $this->ask('Name:');
        $email = $this->ask('Email:');
        $password = $this->secret('Password:');
        $confirm = $this->secret('Confirm Password:');
        if ($password != $confirm) {
            $this->error("Password's don't match");
            $this->handle();
            return;
        }
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'token' => md5(rand(1000, 5000))
        ]);
        $this->info('User created. Visit site to login and get started!');
    }
}
