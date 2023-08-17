<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subscription_types')->insert([
            'name' => "Basic",
            'duration' => "Lifelong",
            'price' => 0,
            'included_benefites' => "Property details management",
        ]);

        DB::table('subscription_types')->insert([
            'name' => "Ultimate",
            'duration' => "from 30 days to 2 years",
            'price' => 50,
            'included_benefites' => "Property details management,Booking Calendar,Payment Gateway,Expanding your Space,Communication tool,Reviews and Ratings Management",
        ]);

        DB::table('subscription_types')->insert([
            'name' => "Free Trial Package",
            'duration' => "30 days",
            'price' => 0,
            'included_benefites' => "Property details management,Booking Calendar,Payment Gateway,Expanding your Space,Communication tool,Reviews and Ratings Management",
        ]);
    }
}
