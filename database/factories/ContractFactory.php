<?php

namespace Database\Factories;

use App\Models\Contract;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contract::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $date = $this->faker->dateTimeBetween('-5 years');

        return [
            'contract_number' => 'Con_'.$this->faker->unique()->numberBetween(1,1000),
            'user_id' => '1',
            'subcontractor_id' => $this->faker->numberBetween(1,10),
            'workitem_id' => $this->faker->numberBetween(1,120),
            'worksite_id' => $this->faker->numberBetween(1,150),
            'created_at'=>$date,
            'updated_at'=>$date
        ];
    }
}
