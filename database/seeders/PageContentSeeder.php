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

        // Home Page Content for SikhoBD
        PageContent::updateOrCreate(
            ['page_slug' => 'home'],
            [
                'title_en' => 'Learn <em>anything</em>,<br>anytime, anywhere',
                'title_bn' => 'শিখুন <em>যেকোনো কিছু</em>,<br>যেকোনো সময়, যেকোনো জায়গায়',
                'subtitle_en' => "Bangladesh's #1 Online School",
                'subtitle_bn' => 'বাংলাদেশের #১ অনলাইন স্কুল',
                'description_en' => '1000+ courses for Class 6-12, admission prep & skill development — all in one place.',
                'description_bn' => 'ক্লাস ৬ থেকে ১২, ভর্তি প্রস্তুতি, স্কিল ডেভেলপমেন্ট সহ ১০০০+ কোর্স একসাথে।',
                'meta' => [
                    'hero_stats' => [
                        ['count' => '2.4M+', 'label_en' => 'Students', 'label_bn' => 'শিক্ষার্থী'],
                        ['count' => '1000+', 'label_en' => 'Courses', 'label_bn' => 'কোর্স'],
                        ['count' => '500+', 'label_en' => 'Teachers', 'label_bn' => 'শিক্ষক']
                    ],
                    'how_it_works' => [
                        'title_en' => 'Start Learning in 3 Easy Steps',
                        'title_bn' => 'সহজ তিন ধাপে শেখা শুরু করুন',
                        'steps' => [
                            [
                                'num' => '01',
                                'title_en' => 'Choose a Course',
                                'title_bn' => 'কোর্স পছন্দ করুন',
                                'desc_en' => 'Pick your favorite course from our vast categories.',
                                'desc_bn' => 'আমাদের বিশাল ক্যাটাগরি থেকে আপনার পছন্দের কোর্সটি বেছে নিন।'
                            ],
                            [
                                'num' => '02',
                                'title_en' => 'Enroll',
                                'title_bn' => 'এনরোল করুন',
                                'desc_en' => 'Get access by enrolling with easy payment methods.',
                                'desc_bn' => 'সহজ পেমেন্ট পদ্ধতিতে কোর্সে ভর্তি হন এবং এক্সেস পান।'
                            ],
                            [
                                'num' => '03',
                                'title_en' => 'Start Learning',
                                'title_bn' => 'শেখা শুরু করুন',
                                'desc_en' => 'Improve your skills with video lessons, quizzes and notes.',
                                'desc_bn' => 'ভিডিও লেসন, কুইজ এবং নোটের মাধ্যমে আপনার দক্ষতা বৃদ্ধি করুন।'
                            ]
                        ]
                    ],
                    'features' => [
                        'title_en' => 'Why SikhoBD?',
                        'title_bn' => 'কেন SikhoBD?',
                        'items' => [
                            [
                                'icon' => 'fa-solid fa-video',
                                'title_en' => 'Live Classes',
                                'title_bn' => 'লাইভ ক্লাস',
                                'desc_en' => 'Real-time live classes with the best teachers in the country.',
                                'desc_bn' => 'দেশের সেরা শিক্ষকদের সাথে রিয়েল-টাইম লাইভ ক্লাস।'
                            ],
                            [
                                'icon' => 'fa-solid fa-book-open',
                                'title_en' => '1000+ Resources',
                                'title_bn' => '১০০০+ রিসোর্স',
                                'desc_en' => 'Videos, notes, quizzes — all in one place.',
                                'desc_bn' => 'ভিডিও, নোট, কুইজ — সব এক জায়গায়।'
                            ],
                            [
                                'icon' => 'fa-solid fa-mobile-screen',
                                'title_en' => 'Any Device',
                                'title_bn' => 'যেকোনো ডিভাইস',
                                'desc_en' => 'Learn from mobile, tablet or computer — anywhere.',
                                'desc_bn' => 'মোবাইল, ট্যাবলেট বা কম্পিউটার থেকে শিখুন — যেকোনো জায়গায়।'
                            ]
                        ]
                    ]
                ],
                'active' => true,
                'addedby_id' => $adminId,
            ]
        );

        // About Page Content
        PageContent::updateOrCreate(
            ['page_slug' => 'about'],
            [
                'title_en' => 'Education for Everyone',
                'title_bn' => 'সবার জন্য শিক্ষা',
                'subtitle_en' => 'Our Story',
                'subtitle_bn' => 'আমাদের গল্প',
                'description_en' => 'SikhoBD is an online learning platform dedicated to providing quality education to students across Bangladesh.',
                'description_bn' => 'SikhoBD একটি অনলাইন লার্নিং প্ল্যাটফর্ম যা সারা বাংলাদেশের শিক্ষার্থীদের মানসম্মত শিক্ষা প্রদানে নিবেদিত।',
                'active' => true,
                'addedby_id' => $adminId,
            ]
        );
    }
}
