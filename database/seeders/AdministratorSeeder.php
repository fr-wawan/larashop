<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User;
        $admin->name = "Site Admin";
        $admin->username = "Admin";
        $admin->email = "admin@gmail.com";
        $admin->roles = json_encode(["ADMIN"]);
        $admin->password = Hash::make("admin");
        $admin->avatar = "no.png";
        $admin->address = "iyh";

        $admin->save();

        $this->command->info("User Admin berhasil diinsert");
    }
}
