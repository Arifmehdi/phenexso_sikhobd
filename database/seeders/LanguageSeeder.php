<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;
use App\Models\Product;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Update/Create Categories with localized names
        $categories = [
            [
                'slug' => 'academic',
                'name_en' => 'Academic',
                'name_bn' => 'একাডেমিক',
                'type' => 'course',
                'active' => true
            ],
            [
                'slug' => 'skill-development',
                'name_en' => 'Skill Development',
                'name_bn' => 'স্কিল ডেভেলপমেন্ট',
                'type' => 'course',
                'active' => true
            ],
            [
                'slug' => 'language-learning',
                'name_en' => 'Language Learning',
                'name_bn' => 'ভাষা শিক্ষা',
                'type' => 'course',
                'active' => true
            ],
        ];

        foreach ($categories as $catData) {
            ProductCategory::updateOrCreate(
                ['slug' => $catData['slug']],
                $catData
            );
        }

        // 2. Update/Create Courses with localized content
        $courses = [
            [
                'slug' => 'web-development-bootcamp',
                'name_en' => 'Complete Web Development Bootcamp',
                'name_bn' => 'কমপ্লিট ওয়েব ডেভেলপমেন্ট বুটক্যাম্প',
                'excerpt_en' => 'Master HTML, CSS, JavaScript, and more.',
                'excerpt_bn' => 'এইচটিএমএল, সিএসএস, জাভাস্ক্রিপ্ট এবং আরও অনেক কিছু শিখুন।',
                'description_en' => '<p>Learn to build beautiful websites from scratch.</p>',
                'description_bn' => '<p>স্ক্র্যাচ থেকে সুন্দর ওয়েবসাইট তৈরি করতে শিখুন।</p>',
                'type' => 'course',
                'active' => true,
                'selling_price' => 5000,
                'duration' => '6 Months',
                'lessons_count' => 120,
                'level' => 'Beginner'
            ],
            [
                'slug' => 'spoken-english-mastery',
                'name_en' => 'Spoken English Mastery',
                'name_bn' => 'স্পোকেন ইংলিশ মাস্টারি',
                'excerpt_en' => 'Speak English fluently and confidently.',
                'excerpt_bn' => 'সাবলীল এবং আত্মবিশ্বাসের সাথে ইংরেজি বলুন।',
                'description_en' => '<p>Master the art of speaking English in any situation.</p>',
                'description_bn' => '<p>যেকোনো পরিস্থিতিতে ইংরেজি বলার শিল্পে দক্ষ হোন।</p>',
                'type' => 'course',
                'active' => true,
                'selling_price' => 2000,
                'duration' => '3 Months',
                'lessons_count' => 45,
                'level' => 'All Levels'
            ]
        ];

        foreach ($courses as $courseData) {
            Product::updateOrCreate(
                ['slug' => $courseData['slug']],
                $courseData
            );
        }
    }
}
