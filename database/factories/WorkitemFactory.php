<?php

namespace Database\Factories;

use App\Models\Workitem;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class WorkitemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Workitem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->faker = FakerFactory::create('ar_SA'); // for arabic
        $this->fakerEn = FakerFactory::create('en_US'); // for english
        $date = $this->faker->dateTimeBetween('-5 years');
        
        return [
            'name' => $this->loopLangs(),
            'user_id' => '1',
            'created_at'=>$date,
            'updated_at'=>$date
        ];
    }

    public function loopLangs(){
        $arrayRequestunique = array();
        foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties){
            if ($localeCode == 'ar') {
                $arrayRequestunique[$localeCode] = $this->faker->catchPhrase;
            }else{
                $arrayRequestunique[$localeCode] = $this->fakerEn->catchPhrase;
            }
            
        }
        return $arrayRequestunique;
    }


}