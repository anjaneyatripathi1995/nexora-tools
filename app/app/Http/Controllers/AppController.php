<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    public function index()
    {
        $apps = [
            ['slug' => 'fitness-app', 'name' => 'Fitness App', 'icon' => 'fa-dumbbell', 'color' => 'danger'],
            ['slug' => 'language-learning', 'name' => 'Language Learning App', 'icon' => 'fa-language', 'color' => 'primary'],
            ['slug' => 'car-parking', 'name' => 'Car Parking App', 'icon' => 'fa-car', 'color' => 'success'],
            ['slug' => 'chatbots', 'name' => 'Chatbots', 'icon' => 'fa-robot', 'color' => 'info'],
            ['slug' => 'docket-management', 'name' => 'Docket Management System', 'icon' => 'fa-folder-open', 'color' => 'warning'],
            ['slug' => 'mental-health', 'name' => 'Mental Health App', 'icon' => 'fa-heart', 'color' => 'danger'],
            ['slug' => 'payments-app', 'name' => 'Payments App', 'icon' => 'fa-credit-card', 'color' => 'success'],
            ['slug' => 'reservation-platform', 'name' => 'Reservation Platform', 'icon' => 'fa-calendar-check', 'color' => 'primary'],
            ['slug' => 'youtube-radio', 'name' => 'YouTube Radio', 'icon' => 'fa-radio', 'color' => 'info'],
            ['slug' => 'book-review', 'name' => 'Book Review App', 'icon' => 'fa-book', 'color' => 'warning'],
            ['slug' => 'ceo-dashboard', 'name' => 'CEO Dashboard', 'icon' => 'fa-chart-line', 'color' => 'primary'],
            ['slug' => 'employee-orientation', 'name' => 'Employee Orientation Software', 'icon' => 'fa-users', 'color' => 'success'],
            ['slug' => 'ev-charging', 'name' => 'EV Charging Station Finder', 'icon' => 'fa-charging-station', 'color' => 'success'],
            ['slug' => 'exam-study', 'name' => 'Exam Study App', 'icon' => 'fa-graduation-cap', 'color' => 'primary'],
            ['slug' => 'grocery-delivery', 'name' => 'Grocery Delivery App', 'icon' => 'fa-shopping-cart', 'color' => 'info'],
            ['slug' => 'health-inspector', 'name' => 'Health Inspector App', 'icon' => 'fa-user-doctor', 'color' => 'warning'],
            ['slug' => 'online-teaching', 'name' => 'Online Teaching Website/App', 'icon' => 'fa-chalkboard-teacher', 'color' => 'warning'],
            ['slug' => 'cooking-suggestions', 'name' => 'Cooking Suggestions App', 'icon' => 'fa-bowl-food', 'color' => 'danger'],
            ['slug' => 'container-tracking', 'name' => 'Container Tracking App', 'icon' => 'fa-box', 'color' => 'primary'],
            ['slug' => 'ebooks', 'name' => 'Ebooks App', 'icon' => 'fa-book-open', 'color' => 'success'],
            ['slug' => 'freelancer-finance', 'name' => 'Freelancer Finance App', 'icon' => 'fa-money-bill-wave', 'color' => 'info'],
        ];

        return view('apps.index', compact('apps'));
    }

    public function show($slug)
    {
        $app = $this->getAppBySlug($slug);
        
        if (!$app) {
            abort(404);
        }

        return view('apps.show', compact('app'));
    }

    private function getAppBySlug($slug)
    {
        $apps = [
            'fitness-app' => [
                'name' => 'Fitness App',
                'icon' => 'fa-dumbbell',
                'color' => 'danger',
                'description' => 'Complete fitness tracking app with workout plans, progress tracking, and nutrition guidance.',
                'features' => ['Workout Plans', 'Progress Tracking', 'Nutrition Guide', 'Social Features'],
                'tech_stack' => ['React Native', 'Node.js', 'MongoDB'],
                'demo_url' => '#',
                'apk_url' => '#',
                'github_url' => '#'
            ],
            // Add more apps as needed
        ];

        return $apps[$slug] ?? [
            'name' => ucfirst(str_replace('-', ' ', $slug)),
            'icon' => 'fa-mobile-screen-button',
            'color' => 'primary',
            'description' => 'Mobile and web application with full source code, APK, and live demo.',
            'features' => ['Full Source Code', 'APK Download', 'Live Demo', 'Documentation'],
            'tech_stack' => ['React Native', 'Laravel', 'MySQL'],
            'demo_url' => '#',
            'apk_url' => '#',
            'github_url' => '#'
        ];
    }
}
