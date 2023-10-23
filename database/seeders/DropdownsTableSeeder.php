<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DropdownsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('dropdowns')->delete();
        
        \DB::table('dropdowns')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Boat',
                'type' => 'Transportation',
                'icon' => 'ri-sailboat-fill',
                'is_expense' => 1,
                'is_loanable' => 1,
                'is_active' => 1,
                'created_at' => '2023-10-07 18:41:11',
                'updated_at' => '2023-10-07 18:41:11',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Carrier',
                'type' => 'Transportation',
                'icon' => 'ri-ship-fill',
                'is_expense' => 1,
                'is_loanable' => 1,
                'is_active' => 1,
                'created_at' => '2023-10-07 18:41:11',
                'updated_at' => '2023-10-07 18:41:11',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Truck',
                'type' => 'Transportation',
                'icon' => 'ri-truck-fill',
                'is_expense' => 1,
                'is_loanable' => 1,
                'is_active' => 1,
                'created_at' => '2023-10-07 18:41:11',
                'updated_at' => '2023-10-07 18:41:11',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Agency',
                'type' => 'Name',
                'icon' => 'ri-building-2-line',
                'is_expense' => 1,
                'is_loanable' => 0,
                'is_active' => 1,
                'created_at' => '2023-10-07 18:41:11',
                'updated_at' => '2023-10-07 18:41:11',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Buyer',
                'type' => 'Name',
                'icon' => 'ri-account-circle-line',
                'is_expense' => 0,
                'is_loanable' => 0,
                'is_active' => 1,
                'created_at' => '2023-10-07 18:41:11',
                'updated_at' => '2023-10-07 18:41:11',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Person',
                'type' => 'Name',
                'icon' => 'ri-team-line',
                'is_expense' => 0,
                'is_loanable' => 0,
                'is_active' => 1,
                'created_at' => '2023-10-07 18:41:11',
                'updated_at' => '2023-10-07 18:41:11',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Service',
                'type' => 'Loan',
                'icon' => 'ri-team-line',
                'is_expense' => 0,
                'is_loanable' => 1,
                'is_active' => 1,
                'created_at' => '2023-10-07 18:41:11',
                'updated_at' => '2023-10-07 18:41:11',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'General',
                'type' => 'Expense',
                'icon' => 'ri-building-2-line',
                'is_expense' => 1,
                'is_loanable' => 0,
                'is_active' => 1,
                'created_at' => '2023-10-07 18:41:11',
                'updated_at' => '2023-10-07 18:41:11',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Expense',
                'type' => 'Name',
                'icon' => 'ri-team-line',
                'is_expense' => 0,
                'is_loanable' => 0,
                'is_active' => 1,
                'created_at' => '2023-10-07 18:41:11',
                'updated_at' => '2023-10-07 18:41:11',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Market',
                'type' => 'Type',
                'icon' => 'ri-store-2-fill',
                'is_expense' => 0,
                'is_loanable' => 0,
                'is_active' => 1,
                'created_at' => '2023-10-07 18:41:11',
                'updated_at' => '2023-10-07 18:41:11',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'External',
                'type' => 'Type',
                'icon' => 'ri-map-pin-2-line',
                'is_expense' => 0,
                'is_loanable' => 0,
                'is_active' => 1,
                'created_at' => '2023-10-07 18:41:11',
                'updated_at' => '2023-10-07 18:41:11',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Bularan',
                'type' => 'Type',
                'icon' => 'ri-sun-fill',
                'is_expense' => 0,
                'is_loanable' => 0,
                'is_active' => 1,
                'created_at' => '2023-10-07 18:41:11',
                'updated_at' => '2023-10-07 18:41:11',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Fishes',
                'type' => 'Fish',
                'icon' => 'ri-sun-fill',
                'is_expense' => 0,
                'is_loanable' => 0,
                'is_active' => 1,
                'created_at' => '2023-10-07 18:41:11',
                'updated_at' => '2023-10-07 18:41:11',
            ),
        ));
        
        
    }
}