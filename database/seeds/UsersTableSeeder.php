<?php
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Created by PhpStorm.
 * User: Lukas Figura
 * Date: 15/03/2017
 * Time: 13:00
 */
class UsersTableSeeder extends Seeder
{
    public function run()
    {

        User::create([
            'name' => 'Slavo',
            'surname' => 'Kozar',
            'email' => 'slavo.kozar@gmail.com',
            'password' => bcrypt('secret'),
        ]);

    }

}