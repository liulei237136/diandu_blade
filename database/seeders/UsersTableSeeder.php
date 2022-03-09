<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // 生成数据集合
         User::factory(10)->create();

         // 单独处理第一个用户的数据
         $user = User::find(1);
         $user->name = 'liulei';
         $user->email = 'liulei237136@163.com';
         $user->password = crypt('ll237136', Str::random(10));
         $user->avatar = 'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png';
         $user->save();
    }
}
