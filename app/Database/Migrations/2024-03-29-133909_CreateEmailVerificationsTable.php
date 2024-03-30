<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmailVerificationsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT','usigned'=>true, 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT','usigned'=>true],
            'code' => ['type' => 'VARCHAR', 'constraint' => 256],
            'created_at datetime default current_timestamp',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id');
        $this->forge->createTable('email_verifications');
    }

    public function down()
    {
       $this->forge->dropTable('email_verifications');
    }
}
