<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class SessionMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $sessions = $this->table('sessions');
        $sessions->addColumn('token', 'string', ['limit' => 100])
            ->addColumn('user_id', 'integer',)
            ->addColumn('expires_at', 'string', ['limit' => 30, 'null' => true])
            ->addTimestamps()
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'RESTRICT'])
            ->addIndex(['token'])
            ->create();
    }
}
