<?php

namespace Database\Factories;

use App\Models\Subcontractor;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SubcontractorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subcontractor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $arabicfaker = $this->faker = FakerFactory::create('ar_SA'); // for arabic
        $englishfaker = $this->fakerEn = FakerFactory::create('en_US'); // for english
        $datetime = $this->faker->dateTimeBetween('-5 years');

        $arrayRequestunique = array();
        foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties){
            if ($localeCode == 'ar') {
                $arrayRequestunique['name'][$localeCode] = $arabicfaker->company;
                $arrayRequestunique['address'][$localeCode] = $arabicfaker->address ;
                $arrayRequestunique['bio'][$localeCode] = $arabicfaker->realText(300, 2);
            }else{
                $arrayRequestunique['name'][$localeCode] = $englishfaker->company;
                $arrayRequestunique['address'][$localeCode] = $englishfaker->address;
                $arrayRequestunique['bio'][$localeCode] = $englishfaker->realText(300, 2);
            }
        }
        $arrayRequestunique['phone'] = $arabicfaker->phoneNumber;
        $arrayRequestunique['email'] = $arabicfaker->unique()->safeEmail;
        $arrayRequestunique['status'] = $arabicfaker->boolean;
        $arrayRequestunique['user_id'] = '1';
        $arrayRequestunique['created_at'] = $datetime;
        $arrayRequestunique['updated_at'] = $datetime;
        
        return $arrayRequestunique;
    }
}
