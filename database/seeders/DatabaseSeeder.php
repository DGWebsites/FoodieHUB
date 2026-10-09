<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $burgers = Category::updateOrCreate(
            ['name' => 'Burgers'],
            [
                'description' => 'Fresh and delicious burgers.',
                'is_active' => true,
            ]
        );

        $pizza = Category::updateOrCreate(
            ['name' => 'Pizza'],
            [
                'description' => 'Hot and freshly prepared pizzas.',
                'is_active' => true,
            ]
        );

        $chicken = Category::updateOrCreate(
            ['name' => 'Chicken'],
            [
                'description' => 'Crispy and flavorful chicken meals.',
                'is_active' => true,
            ]
        );

        $drinks = Category::updateOrCreate(
            ['name' => 'Drinks'],
            [
                'description' => 'Refreshing drinks for your meal.',
                'is_active' => true,
            ]
        );

        Product::updateOrCreate(
            ['name' => 'Classic Cheeseburger'],
            [
                'category_id' => $burgers->id,
                'description' => 'Juicy beef patty with cheese, lettuce, tomato, and our special sauce.',
                'price' => 129.00,
                'image' => null,
                'is_available' => true,
            ]
        );

        Product::updateOrCreate(
            ['name' => 'Double Bacon Burger'],
            [
                'category_id' => $burgers->id,
                'description' => 'Two beef patties with crispy bacon and melted cheese.',
                'price' => 179.00,
                'image' => null,
                'is_available' => true,
            ]
        );

        Product::updateOrCreate(
            ['name' => 'Pepperoni Pizza'],
            [
                'category_id' => $pizza->id,
                'description' => 'Classic pizza topped with pepperoni and melted cheese.',
                'price' => 299.00,
                'image' => null,
                'is_available' => true,
            ]
        );

            Product::updateOrCreate(
            ['name' => 'Chicken Pizza'],
            [
                'category_id' => $pizza->id,
                'description' => 'Cheesy pizza topped with seasoned chicken.',
                'price' => 329.00,
                'image' => null,
                'is_available' => true,
            ]
        );

        Product::updateOrCreate(
            ['name' => 'Crispy Chicken'],
            [
                'category_id' => $chicken->id,
                'description' => 'Crispy fried chicken served hot and fresh.',
                'price' => 149.00,
                'image' => null,
                'is_available' => true,
            ]
        );

        Product::updateOrCreate(
            ['name' => 'Chicken Rice Meal'],
            [
                'category_id' => $chicken->id,
                'description' => 'Crispy chicken served with steamed rice.',
                'price' => 119.00,
                'image' => null,
                'is_available' => true,
            ]
        );

        Product::updateOrCreate(
            ['name' => 'Iced Tea'],
            [
                'category_id' => $drinks->id,
                'description' => 'Refreshing chilled iced tea.',
                'price' => 49.00,
                'image' => null,
                'is_available' => true,
            ]
        );

        Product::updateOrCreate(
            ['name' => 'Soft Drink'],
            [
                'category_id' => $drinks->id,
                'description' => 'Cold and refreshing soft drink.',
                'price' => 45.00,
                'image' => null,
                'is_available' => true,
            ]
        );
    }
}