<?php

namespace Database\Factories;

use Modules\Common\Entities\File;
use Illuminate\Database\Eloquent\Factories\Factory;

class UploadFileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = File::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        ];
    }
}
