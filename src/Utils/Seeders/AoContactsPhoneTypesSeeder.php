<?php

use Illuminate\Database\Seeder;

class AoContactsPhoneTypesSeeder extends Seeder
{

    public function run()
    {
        $items = [
            ['id' => 1, 'name' => 'Pessoal'],
            ['id' => 2, 'name' => 'Casa'],
            ['id' => 3, 'name' => 'Trabalho'],
            ['id' => 4, 'name' => 'Fax Trabalho'],
            ['id' => 5, 'name' => 'Fax Casa'],
            ['id' => 6, 'name' => 'Pager'],
            ['id' => 7, 'name' => 'Outro']
        ];

        foreach ($items as $item) {
            $phone = new AoContacts\Models\PhoneType ();
            $phone->name = $item['name'];
            $phone->save();
        }
    }

}