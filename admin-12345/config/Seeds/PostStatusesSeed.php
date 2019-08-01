<?php
use Migrations\AbstractSeed;

/**
 * PostStatuses seed.
 */
class PostStatusesSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => '1',
                'name' => 'Published',
                'rank' => '1',
            ],
            [
                'id' => '2',
                'name' => 'Draft',
                'rank' => '2',
            ],
        ];

        $table = $this->table('post_statuses');
        $table->insert($data)->save();
    }
}
