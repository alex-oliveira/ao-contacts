<?php

use Illuminate\Database\Seeder;

class AoContactsEmailTypesSeeder extends Seeder
{

    public function run()
    {
        $items = [
            ['id' => 1, 'name' => 'Pessoal'],
            ['id' => 2, 'name' => 'Trabalho'],
            ['id' => 3, 'name' => 'Outro'],
        ];

        foreach ($items as $item) {
            $email = new AoContacts\Models\EmailType();
            $email->name = $item['name'];
            $email->save();
        }
    }

}