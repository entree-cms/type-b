<?php
use Migrations\AbstractSeed;

/**
 * Users seed.
 */
class UsersSeed extends AbstractSeed
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
                'username' => 'admin',
                'password' => '$2y$10$Fm1v2yMqn1oD8BZyUESiw.PIiuzcUo8y1DwYOdKeeA/Lwc.FZTAny',
                'first_name' => 'Admin',
                'last_name' => 'Site',
                'nickname' => 'Administrator',
                'email' => NULL,
                'deleted' => NULL,
                'created' => '2019-07-07 00:00:00',
                'modified' => '2019-07-07 00:00:00',
            ],
        ];

        $table = $this->table('users');
        $table->insert($data)->save();
    }
}
