<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;

class UserTest extends AbstractModelTestCase
{
    /**
     * @var User
     */
    protected $model;

    /**
     * Assert model uses required traits.
     *
     * @return void
     */
    public function testTraits(): void
    {
        $this->assertClassUsesTraits(User::class, [
            Authenticatable::class,
            Notifiable::class,
            SoftDeletes::class,
            Authorizable::class,
        ]);
    }

    /**
     * Test password hashing method.
     *
     * @return void
     */
    public function testHashPassword(): void
    {
        foreach (['foo', 'bar', ''] as $test_case) {
            $this->assertNotEquals($test_case, $result = User::hashPassword($test_case));
            $this->assertNotEmpty($result);

            $this->assertTrue(Hash::check($test_case, $result));
        }
    }

    /**
     * Test model fillable attributes.
     *
     * @return void
     */
    public function testFillable(): void
    {
        $this->assertModelHasFillableAttributes([
            'login',
            'display_name',
            'password',
        ]);
    }

    /**
     * Test password setter attribute (mutator).
     *
     * @return void
     */
    public function testSetPasswordAttribute(): void
    {
        foreach (['foo', 'bar', 'baz 123 #$%'] as $password) {
            // Set 'plain' password
            $this->model->password = $password;
            $this->assertTrue(Hash::check($password, $this->model->password));

            // Set password as hash
            $this->model->password = Hash::make($password);
            $this->assertTrue(Hash::check($password, $this->model->password));
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function modelFactory(array $attributes = []): User
    {
        return factory(User::class)->create($attributes);
    }
}
