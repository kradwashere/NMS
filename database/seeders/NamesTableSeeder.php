<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class NamesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('names')->delete();
        
        \DB::table('names')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Fatima 3',
                'type_id' => 1,
                'is_active' => 1,
                'created_at' => '2023-10-07 22:17:07',
                'updated_at' => '2023-10-07 22:17:15',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'NMS',
                'type_id' => 2,
                'is_active' => 1,
                'created_at' => '2023-10-07 22:17:50',
                'updated_at' => '2023-10-07 22:17:50',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Dummy truck 1',
                'type_id' => 3,
                'is_active' => 1,
                'created_at' => '2023-10-07 22:19:47',
                'updated_at' => '2023-10-07 22:20:07',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'dummy truck 2',
                'type_id' => 3,
                'is_active' => 1,
                'created_at' => '2023-10-07 22:19:56',
                'updated_at' => '2023-10-07 22:19:56',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Bureau of Fisheries and Aquatic Resources',
                'type_id' => 4,
                'is_active' => 1,
                'created_at' => '2023-10-07 22:36:37',
                'updated_at' => '2023-10-07 22:36:37',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Philippine Coast Guard',
                'type_id' => 4,
                'is_active' => 1,
                'created_at' => '2023-10-07 22:37:03',
                'updated_at' => '2023-10-07 22:37:03',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'MARITIME INDUSTRY AUTHORITY',
                'type_id' => 4,
                'is_active' => 1,
                'created_at' => '2023-10-07 22:38:36',
                'updated_at' => '2023-10-07 22:38:36',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'island owner',
                'type_id' => 4,
                'is_active' => 1,
                'created_at' => '2023-10-07 22:40:15',
                'updated_at' => '2023-10-07 22:40:15',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'umra bularan',
                'type_id' => 5,
                'is_active' => 1,
                'created_at' => '2023-10-07 22:41:02',
                'updated_at' => '2023-10-07 22:41:02',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'utoh bularan',
                'type_id' => 5,
                'is_active' => 1,
                'created_at' => '2023-10-07 22:41:11',
                'updated_at' => '2023-10-07 22:41:11',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'dah atteng',
                'type_id' => 5,
                'is_active' => 1,
                'created_at' => '2023-10-07 22:42:01',
                'updated_at' => '2023-10-07 22:42:01',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'hji. halim',
                'type_id' => 5,
                'is_active' => 1,
                'created_at' => '2023-10-07 22:42:11',
                'updated_at' => '2023-10-07 22:42:11',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'muffair',
                'type_id' => 5,
                'is_active' => 1,
                'created_at' => '2023-10-07 22:42:20',
                'updated_at' => '2023-10-07 22:42:20',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'harun',
                'type_id' => 5,
                'is_active' => 1,
                'created_at' => '2023-10-07 22:42:28',
                'updated_at' => '2023-10-07 22:42:28',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'hji. rozdy',
                'type_id' => 5,
                'is_active' => 1,
                'created_at' => '2023-10-07 22:42:46',
                'updated_at' => '2023-10-07 22:42:46',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'whang',
                'type_id' => 5,
                'is_active' => 1,
                'created_at' => '2023-10-07 22:42:52',
                'updated_at' => '2023-10-07 22:42:52',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'karim',
                'type_id' => 5,
                'is_active' => 1,
                'created_at' => '2023-10-07 22:42:59',
                'updated_at' => '2023-10-07 22:42:59',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'otchoy',
                'type_id' => 5,
                'is_active' => 1,
                'created_at' => '2023-10-07 22:43:06',
                'updated_at' => '2023-10-07 22:43:06',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'ustadz muktar',
                'type_id' => 5,
                'is_active' => 1,
                'created_at' => '2023-10-07 22:43:20',
                'updated_at' => '2023-10-07 22:43:20',
            ),
        ));
        
        
    }
}