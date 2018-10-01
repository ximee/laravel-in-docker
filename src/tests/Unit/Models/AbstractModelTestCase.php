<?php

namespace Tests\Unit\Models;

use App\Models\AbstractBaseModel;
use Tests\Unit\AbstractUnitTestCase;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractModelTestCase extends AbstractUnitTestCase
{
    /**
     * @var AbstractBaseModel|Model
     */
    protected $model;

    /**
     * Model factory attributes.
     *
     * @var array
     */
    protected $factory_attributes = [];

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->model = $this->modelFactory((array) $this->factory_attributes);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        if ($this->model instanceof Model) {
            $this->model->forceDelete();
        }

        unset($this->model);

        parent::tearDown();
    }

    /**
     * Assert model has fillable attributes.
     *
     * @param array $needed_values
     */
    protected function assertModelHasFillableAttributes(array $needed_values): void
    {
        $model_fillable = $this->model->getFillable();

        foreach ($needed_values as $needle) {
            $this->assertContains(
                $needle,
                $model_fillable,
                'Model has no fillable "' . $needle . '" attribute'
            );
        }
    }

    /**
     * Tested model factory.
     *
     * @param array $attributes
     *
     * @return Model
     */
    abstract protected function modelFactory(array $attributes = []);
}
