<?php

namespace Database\Factories;

use App\Models\Document;
use App\Models\MobileAppUser;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bookmark>
 */
class BookmarkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $bookmark_type = $this->faker->randomElement([Product::class, Document::class]);
        $user = MobileAppUser::whereHas('companies')->inRandomOrder()->first();
        $available_companies = $user->companies->pluck('id');
        if ($bookmark_type == Product::class) {
            $bookmarkable = Product::whereIn('company_id', $available_companies)->inRandomOrder()->first();
        } else {
            $bookmarkable = Document::whereHas('product', fn ($q) => $q->whereIn('company_id', $available_companies))->inRandomOrder()->first();
        }

        return [
            'bookmarkable_type'         =>  $bookmark_type,
            'bookmarkable_id'           =>  $bookmarkable->id,
            'mobile_app_user_id'        =>  $user->id,
        ];
    }
}
