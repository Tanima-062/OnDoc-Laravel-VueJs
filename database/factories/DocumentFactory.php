<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $type = $this->faker->randomElement(['file', 'url']);
        $file_path = 'demo/pdfs/'.mt_rand(1, 10).'.pdf';
        $user = User::factory()->create();
        return [
            'product_id'            =>  function(){
                return Product::factory()->create()->id;
            },
            'user_id' => function() use ($user){
                return $user->id;
            },
            'company_id'            => $user->company_id,
            'name'                  =>  $this->faker->name,
            'type'                  =>  $type,
            'section'               =>  $this->faker->randomElement( ['technical', 'supplier', 'drawing', 'instruction', 'modification_guide']),
            'filepath'              =>  $type == 'file' ? $file_path: Storage::disk('demo')->url($file_path),
            'disk'                  =>  $type == 'file' ? 'demo': null
        ];
    }
}
