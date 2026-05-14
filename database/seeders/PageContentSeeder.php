<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageContent;
use App\Models\User;

class PageContentSeeder extends Seeder
{
    public function run()
    {
        $admin = User::first();
        $adminId = $admin ? $admin->id : null;

        // Home Page Content
        PageContent::updateOrCreate(
            ['page_slug' => 'home'],
            [
                'title' => 'MN Coffee <br class="d-none d-xxl-block"> Local Beans, Global Taste.',
                'subtitle' => 'about us',
                'description' => 'MN Coffee is a Bangladesh-based specialty coffee venture connecting hill farmers with urban cafés through a direct farm-to-market supply chain. We focus on improving quality, traceability, and farmer income by developing local Arabica production and better post-harvest practices.',
                'highlights' => [
                    'B2B supply of roasted coffee beans (Arabica & Robusta)',
                    'Direct sourcing from Bandarban hill farmers',
                    'Custom roast profiles for cafés',
                    'Quality-controlled and traceable coffee supply'
                ],
                'meta' => [
                    'process_title' => 'Our Specialty Process',
                    'process_subtitle' => 'From direct farm sourcing to custom roasting, discover how we bring the best coffee to your cup.',
                    'offer_title' => 'Try Our Special Offers',
                    'offer_subtitle' => 'Check out our featured products and special deals.',
                    'testimonial_title' => 'What Our Customer Says',
                    'testimonial_subtitle' => 'Hear from our satisfied customers about their experience with us.',
                    'blog_title' => 'Blog & Articles',
                    'blog_subtitle' => 'Stay updated with our latest news and recipes.',
                    'counter_bg' => 'mncofee/assets/img/aida-images/reservation-bg.png',
                    'counters' => [
                        ['count' => '5670', 'label' => 'Happy Customers', 'icon' => 'fa-light fa-face-smile'],
                        ['count' => '29', 'label' => 'Passionate Chefs', 'icon' => 'fa-light fa-hat-chef'],
                        ['count' => '260', 'label' => 'Favorite Dishes', 'icon' => 'fa-light fa-mug-hot'],
                        ['count' => '778', 'label' => 'Customer Rating', 'icon' => 'fa-light fa-star']
                    ]
                ],
                'active' => true,
                'addedby_id' => $adminId,
            ]
        );

        // About Us Page Content
        PageContent::updateOrCreate(
            ['page_slug' => 'about'],
            [
                'title' => 'Specialty Coffee Venture <br> in Bangladesh',
                'subtitle' => 'Our Story',
                'description' => 'MN Coffee is a Bangladesh-based specialty coffee venture connecting hill farmers with urban cafés through a direct farm-to-market supply chain. We focus on improving quality, traceability, and farmer income by developing local Arabica production and better post-harvest practices.',
                'highlights' => [
                    ['title' => 'Our Mission', 'text' => 'To build a sustainable, high-quality local coffee industry that benefits farmers and meets premium market demand.'],
                    ['title' => 'Our Vision', 'text' => 'To position Bangladesh as an emerging origin for specialty coffee.']
                ],
                'meta' => [
                    'focus_title' => 'Key Objectives',
                    'focus_subtitle' => 'Our Focus',
                    'objectives' => [
                        ['icon' => 'fa-light fa-users-viewfinder', 'title' => 'Farmer Income', 'text' => 'Connecting hill farmers directly to markets to ensure fair and improved income.'],
                        ['icon' => 'fa-light fa-microscope', 'title' => 'Traceability', 'text' => 'Maintaining full traceability from the specific hill farm to your urban café cup.'],
                        ['icon' => 'fa-light fa-chart-line-up', 'title' => 'Arabica Growth', 'text' => 'Developing and expanding local Arabica production in the Chittagong Hill Tracts.']
                    ]
                ],
                'active' => true,
                'addedby_id' => $adminId,
            ]
        );

        // Our Process Page Content
        PageContent::updateOrCreate(
            ['page_slug' => 'process'],
            [
                'title' => 'Our Direct Farm-to-Market Supply Chain',
                'subtitle' => 'Our Process',
                'description' => 'We focus on improving quality, traceability, and farmer income through a meticulous post-harvest process.',
                'highlights' => [
                    ['title' => 'Direct Sourcing'],
                    ['title' => 'Post-Harvest'],
                    ['title' => 'Urban Supply']
                ],
                'meta' => [
                    'steps' => [
                        [
                            'title' => 'Direct Farm Sourcing',
                            'text' => 'We work directly with Bandarban hill farmers, cutting out middlemen to ensure higher income for the producers. This direct connection allows us to maintain full traceability of every bean.',
                            'image' => 'mncofee/assets/img/aida-images/about-picture1.png'
                        ],
                        [
                            'title' => 'Post-Harvest Excellence',
                            'text' => 'Our team implements better post-harvest practices on the ground. From precise fermentation to controlled drying, we ensure the local Arabica and Robusta beans reach their full specialty potential.',
                            'image' => 'mncofee/assets/img/aida-images/service-image1.png'
                        ],
                        [
                            'title' => 'Custom Roasting & Supply',
                            'text' => 'We develop custom roast profiles specifically for urban cafés. Our quality-controlled B2B supply chain delivers the global taste of local beans directly to your business.',
                            'image' => 'mncofee/assets/img/aida-images/about-picture3.png'
                        ]
                    ]
                ],
                'active' => true,
                'addedby_id' => $adminId,
            ]
        );
    }
}
