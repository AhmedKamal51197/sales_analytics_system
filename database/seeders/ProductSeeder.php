<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Electric Blender',
                'description' => 'A high-quality electric blender for smoothies, juices, and more.',
                'price' => 99.99,
                'image' => 'images/blender.jpg',
            ],
            [
                'name' => 'Stainless Steel Jar',
                'description' => 'Durable and stylish stainless steel jar for various uses.',
                'price' => 25.50,
                'image' => 'images/jar.jpg',
            ],
            [
                'name' => 'Replacement Electric Tool Set',
                'description' => 'Comprehensive set of replacement tools for electric appliances.',
                'price' => 49.99,
                'image' => 'images/tools.jpg',
            ],
            [
                'name' => 'Portable Heater',
                'description' => 'A compact and efficient portable heater for personal use.',
                'price' => 75.00,
                'image' => 'images/heater.jpg',
            ],
            [
                'name' => 'Electric Kettle',
                'description' => 'Quick boiling electric kettle for hot beverages.',
                'price' => 35.99,
                'image' => 'images/kettle.jpg',
            ],
            [
                'name' => 'Cordless Vacuum Cleaner',
                'description' => 'Lightweight and powerful cordless vacuum cleaner.',
                'price' => 150.00,
                'image' => 'images/vacuum.jpg',
            ],
            [
                'name' => 'Coffee Maker',
                'description' => 'Brew your favorite coffee with this easy-to-use coffee maker.',
                'price' => 40.99,
                'image' => 'images/coffee_maker.jpg',
            ],
            [
                'name' => 'Electric Rice Cooker',
                'description' => 'An automatic rice cooker with keep-warm function.',
                'price' => 60.50,
                'image' => 'images/rice_cooker.jpg',
            ],
            [
                'name' => 'Microwave Oven',
                'description' => 'A convenient microwave oven for fast cooking and reheating.',
                'price' => 99.00,
                'image' => 'images/microwave.jpg',
            ],
            [
                'name' => 'Smartphone Stand',
                'description' => 'Adjustable stand for smartphones and tablets.',
                'price' => 15.99,
                'image' => 'images/phone_stand.jpg',
            ],
            [
                'name' => 'Electric Grill',
                'description' => 'Compact electric grill for indoor cooking.',
                'price' => 80.00,
                'image' => 'images/grill.jpg',
            ],
            [
                'name' => 'Personal Blender',
                'description' => 'Portable personal blender for making smoothies on-the-go.',
                'price' => 25.00,
                'image' => 'images/personal_blender.jpg',
            ],
            [
                'name' => 'Fitness Tracker Watch',
                'description' => 'A smart fitness tracker to monitor your health.',
                'price' => 45.00,
                'image' => 'images/fitness_tracker.jpg',
            ],
            [
                'name' => 'Bluetooth Speaker',
                'description' => 'Wireless Bluetooth speaker for high-quality music.',
                'price' => 70.00,
                'image' => 'images/speaker.jpg',
            ],
            [
                'name' => 'Smart Thermostat',
                'description' => 'Energy-efficient smart thermostat for home temperature control.',
                'price' => 120.00,
                'image' => 'images/thermostat.jpg',
            ],
            [
                'name' => 'Laptop Cooling Pad',
                'description' => 'Cooling pad to keep your laptop cool during use.',
                'price' => 25.00,
                'image' => 'images/cooling_pad.jpg',
            ],
            [
                'name' => 'LED Desk Lamp',
                'description' => 'Energy-efficient LED desk lamp with adjustable brightness.',
                'price' => 30.00,
                'image' => 'images/desk_lamp.jpg',
            ],
            [
                'name' => 'Portable Air Purifier',
                'description' => 'Compact air purifier for improving air quality.',
                'price' => 55.00,
                'image' => 'images/air_purifier.jpg',
            ],
            [
                'name' => 'Electric Hot Plate',
                'description' => 'Portable electric hot plate for cooking anywhere.',
                'price' => 40.00,
                'image' => 'images/hot_plate.jpg',
            ],
            [
                'name' => 'Dishwasher Safe Container Set',
                'description' => 'Set of durable containers safe for the dishwasher.',
                'price' => 20.99,
                'image' => 'images/container_set.jpg',
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

    }
}
