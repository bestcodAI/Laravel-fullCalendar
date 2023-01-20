<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddDummyEvent extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['title'=>'Demo Event-1','start'=>'2023-01-18','end'=>'2023-01-20'],
            ['title'=>'Demo Event-2','start'=>'2023-01-18','end'=>'2023-01-22'],
            ['title'=>'Demo Event-3','start'=>'2023-02-02', 'end'=>'2023-02-20'],
            ['title'=>'Demo Envent-4','start'=>'2023-02-13','end'=>'2023-03-01'],
        ];
        foreach ($data as $key => $value){
            Event::create($value);
        }
    }
}
