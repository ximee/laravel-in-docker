<?php

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Array with users which must be created with static (fixed) logins and passwords. Key is login, value - password.
     *
     * @var array
     */
    protected $static_users = [
        'root'  => 'root',
        'admin' => 'admin',
    ];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        foreach ($this->static_users as $login => $password) {
            $this->createStaticUser($login, $password);
        }

        $this->seedModelsBatch();
    }

    /**
     * Create 'static' user model.
     *
     * @param string $login
     * @param string $password
     *
     * @return void
     */
    protected function createStaticUser(string $login = 'root', string $password = 'root'): void
    {
        if (User::where('login', '=', $login)->doesntExist()) {
            $this->log("Create static user model: <comment>{$login}:{$password}</comment>");

            factory(User::class)->create([
                'login'        => $login,
                'display_name' => $login,
                'password'     => $password,
                'deleted_at'   => null,
            ]);
        } else {
            $this->log("Static user model ({$login}:{$password}) already exists");
        }
    }

    /**
     * Batch models creating.
     *
     * @return void
     */
    protected function seedModelsBatch(): void
    {
        $rules = [
            User::class => random_int(2, 4),
        ];

        foreach ($rules as $class_name => $models_count) {
            $this->log(sprintf(
                '%s <comment>(%d %s)</comment>', $class_name, $models_count, Str::plural('model', $models_count)
            ));

            factory($class_name)->times($models_count)->create();
        }
    }

    /**
     * Log some message into console.
     *
     * @param string $message
     *
     * @return void
     */
    protected function log(string $message): void
    {
        $this->command->getOutput()->writeln("<comment>Seed:</comment> $message");
    }
}
