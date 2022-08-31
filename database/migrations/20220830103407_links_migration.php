<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class LinksMigration extends AbstractMigration
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
        $links = $this->table('links');
        $links->addColumn('user_id', 'integer', ['null' => true])
            ->addColumn('title', 'string', ['limit' => 30, 'null' => true])
            ->addColumn('original_link', 'text', ['limit' => 400])
            ->addColumn('short_link', 'string', ['limit' => 10])
            ->addTimestamps()
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'RESTRICT'])
            ->addIndex(['short_link'], ['unique' => true])
            ->create();
    }
}
