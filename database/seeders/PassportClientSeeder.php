<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Laravel\Passport\Client;
use Str;

class PassportClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $client = Client::create([
            'user_id' => null,
            'name' => 'Personal Access Client',
            'redirect' => 'http://localhost',
            'personal_access_client' => true,
            'password_client' => false,
            'revoked' => false,
            'secret' => Str::random(40), // Generate a random secret
        ]);

        DB::table('oauth_personal_access_clients')->insert([
            'client_id' => $client->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
