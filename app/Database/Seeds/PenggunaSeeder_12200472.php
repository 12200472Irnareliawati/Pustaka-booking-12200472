<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PenggunaSeeder_12200472 extends Seeder
{
    public function run()
    {
        $data =[
        [
            'nama'      => 'Irna',
        'password'  => md5('12200472')
        ],
        [
            'nama'      => 'admin',
        'password'  => md5('12345')
        ],
        [
            'nama'      => '12200472',
        'password'  => md5('IrnaReliaWati')
        ]
    ];

    $p = new Pengguna();
    $p->insertBatch($data);
    }
}
