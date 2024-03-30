<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT','usigned'=>true, 'constraint' => 10, 'auto_increment' => true],
            'email' => ['type' => 'VARCHAR', 'constraint' => 256],
            'password' => ['type' => 'VARCHAR', 'constraint' => 256],
            'is_verified' => ['type' => 'tinyint', 'constraint' => 1, 'default'=>0],
            'created_at datetime default current_timestamp',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
       $this->forge->dropTable('users');
    }
}
