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

        // Home Page Content for Qalam HR
        PageContent::updateOrCreate(
            ['page_slug' => 'home'],
            [
                'title' => 'Learn anything, anytime, anywhere',
                'title_en' => 'Learn <em>anything</em>,<br>anytime, anywhere',
                'title_bn' => 'শিখুন <em>যেকোনো কিছু</em>,<br>যেকোনো সময়, যেকোনো জায়গায়',
                'subtitle' => "Bangladesh's #1 Online Training School",
                'subtitle_en' => "Bangladesh's #1 Online Training School",
                'subtitle_bn' => 'বাংলাদেশের #১ অনলাইন ট্রেনিং স্কুল',
                'description' => '1000+ courses for Class 6-12, admission prep & skill development — all in one place.',
                'description_en' => '1000+ courses for Class 6-12, admission prep & skill development — all in one place.',
                'description_bn' => 'ক্লাস ৬ থেকে ১২, ভর্তি প্রস্তুতি, স্কিল ডেভেলপমেন্ট সহ ১০০০+ কোর্স একসাথে।',
                'content' => 'Qalam HR is a premier e-learning platform.',
                'content_en' => '',
                'content_bn' => '',
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
                        'title_en' => 'Why Qalam HR?',
                        'title_bn' => 'কেন Qalam HR?',
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

        // About Page Content for Qalam HR
        PageContent::updateOrCreate(
            ['page_slug' => 'about'],
            [
                'title' => 'About Qalam HR',
                'title_en' => 'About Us',
                'title_bn' => 'আমাদের সম্পর্কে',
                'subtitle' => 'Education for all — our journey started with this belief',
                'subtitle_en' => 'Education for all — our journey started with this belief',
                'subtitle_bn' => 'শিক্ষা সবার জন্য — এই বিশ্বাস থেকেই আমাদের যাত্রা শুরু',
                'description' => 'QalamHR is one of the premier training institutes in Bangladesh. We create professionals.',
                'description_en' => 'QalamHR is one of the premier training institutes in Bangladesh. We create professionals. Our high-quality courses are designed to increase your professional knowledge, skills, and attitude. All training programs are crafted by industry experts.',
                'description_bn' => 'QalamHR বাংলাদেশের অন্যতম শীর্ষস্থানীয় ট্রেনিং ইনস্টিটিউট। আমরা দক্ষ ও পেশাদার জনবল তৈরি করি। আমাদের উচ্চমানের কোর্সগুলো আপনার পেশাগত জ্ঞান, দক্ষতা এবং মানসিকতা উন্নত করার জন্য ডিজাইন করা হয়েছে। সব প্রশিক্ষণ প্রোগ্রাম ইন্ডাস্ট্রির অভিজ্ঞ বিশেষজ্ঞদের দ্বারা তৈরি করা হয়।',
                'content' => 'Full About Us content.',
                'content_en' => '',
                'content_bn' => '',
                'meta' => [
                    'story_title_en' => 'Our Story',
                    'story_title_bn' => 'আমাদের গল্প',
                    'mission_title_en' => 'Mission',
                    'mission_title_bn' => 'মিশন',
                    'mission_description_en' => 'Empower every student in Bangladesh with world-class learning tools.',
                    'mission_description_bn' => 'বাংলাদেশের প্রতিটি শিক্ষার্থীকে বিশ্বমানের শেখার সরঞ্জামের মাধ্যমে ক্ষমতায়িত করা।',
                    'impact' => [
                        'title_en' => 'Our Impact',
                        'title_bn' => 'আমাদের প্রভাব',
                        'items' => [
                            [
                                'icon' => 'fa-solid fa-users',
                                'title_en' => '2.4M+ Students',
                                'title_bn' => '২৪ লক্ষ+ শিক্ষার্থী',
                                'desc_en' => 'Across 64 districts of Bangladesh.',
                                'desc_bn' => 'বাংলাদেশের ৬৪টি জেলা জুড়ে।'
                            ],
                            [
                                'icon' => 'fa-solid fa-graduation-cap',
                                'title_en' => '1000+ Courses',
                                'title_bn' => '১০০০+ কোর্স',
                                'desc_en' => 'From Class 6 to professional skills.',
                                'desc_bn' => '৬ষ্ঠ শ্রেণি থেকে পেশাদার দক্ষতা পর্যন্ত।'
                            ],
                            [
                                'icon' => 'fa-solid fa-trophy',
                                'title_en' => '15 Awards',
                                'title_bn' => '১৫টি পুরস্কার',
                                'desc_en' => 'National & international recognition.',
                                'desc_bn' => 'জাতীয় ও আন্তর্জাতিক স্বীকৃতি।'
                            ]
                        ]
                    ]
                ],
                'active' => true,
                'addedby_id' => $adminId,
            ]
        );
    }
}
