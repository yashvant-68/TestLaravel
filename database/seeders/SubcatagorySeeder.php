<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subcatagory;

class SubcatagorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                'name'=>'suit',
                'catagory'=>1
            ],
            [
                'name'=>'jeans',
                'catagory'=>1
            ],
            [
                'name'=>'jacket',
                'catagory'=>1
            ],
        ];
        foreach($datas as $data){
            Subcatagory::create($data);
        }
    }
}
