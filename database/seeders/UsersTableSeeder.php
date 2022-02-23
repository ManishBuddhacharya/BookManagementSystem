<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(['email'=>'admin@admin.com'],[
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@admin.com',
            'phone_no' => '9999999999',
            'password' => Crypt::encrypt('password'),
            'is_admin' => 1,
        ])->update([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@admin.com',
            'phone_no' => '9999999999',
            'password' => Crypt::encrypt('password'),
            'is_admin' => 1,
        ]);
    }

}