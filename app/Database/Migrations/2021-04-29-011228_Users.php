<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'role' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
        ]);
        $this->forge->addKey('id');
        $this->forge->createTable('users');
    }
 
    public function down()
    {
        //
    }
}
