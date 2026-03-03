<?php

namespace App\Http\Controllers;

use App\Models\SavedItem;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = [
            [
                'slug' => 'tax-invoicing',
                'name' => 'Tax/Invoicing App',
                'icon' => 'fa-receipt',
                'color' => 'success',
                'description' => 'Complete invoicing and tax management solution with PDF generation, invoice tracking, and tax calculations.',
                'features' => ['Invoice Generation', 'Tax Calculations', 'PDF Export', 'Payment Tracking', 'Reports & Analytics']
            ],
            [
                'slug' => 'restaurant-booking',
                'name' => 'Restaurant Booking App',
                'icon' => 'fa-utensils',
                'color' => 'danger',
                'description' => 'Web + Mobile restaurant reservation system with real-time table availability and booking management.',
                'features' => ['Table Booking', 'Real-time Availability', 'Mobile App', 'Email Notifications', 'Admin Dashboard']
            ],
            [
                'slug' => 'expense-tracker',
                'name' => 'Expense Tracker App',
                'icon' => 'fa-wallet',
                'color' => 'primary',
                'description' => 'Track and manage your expenses efficiently with categories, budgets, and detailed reports.',
                'features' => ['Expense Tracking', 'Category Management', 'Budget Planning', 'Reports', 'Export Data']
            ],
            [
                'slug' => 'todo-list',
                'name' => 'To-Do List App',
                'icon' => 'fa-list-check',
                'color' => 'info',
                'description' => 'Productive task management application with priorities, deadlines, and collaboration features.',
                'features' => ['Task Management', 'Priorities', 'Deadlines', 'Collaboration', 'Reminders']
            ],
            [
                'slug' => 'online-teaching',
                'name' => 'Online Teaching Platform',
                'icon' => 'fa-chalkboard-teacher',
                'color' => 'warning',
                'description' => 'Complete e-learning management system with courses, assignments, and student progress tracking.',
                'features' => ['Course Management', 'Video Lessons', 'Assignments', 'Progress Tracking', 'Certificates']
            ],
            [
                'slug' => 'ceo-dashboard',
                'name' => 'CEO Dashboard',
                'icon' => 'fa-chart-line',
                'color' => 'primary',
                'description' => 'Executive analytics and insights dashboard with real-time KPIs and business metrics.',
                'features' => ['Real-time KPIs', 'Business Metrics', 'Data Visualization', 'Custom Reports', 'Export Options']
            ],
            [
                'slug' => 'employee-orientation',
                'name' => 'Employee Orientation App',
                'icon' => 'fa-users',
                'color' => 'success',
                'description' => 'Streamlined employee onboarding and orientation platform with interactive modules.',
                'features' => ['Onboarding Modules', 'Interactive Content', 'Progress Tracking', 'Documentation', 'Quizzes']
            ],
        ];

        return view('projects.index', compact('projects'));
    }

    public function show($slug)
    {
        $project = $this->getProjectBySlug($slug);

        if (!$project) {
            abort(404);
        }

        $isSaved = auth()->check() && SavedItem::where('user_id', auth()->id())
            ->where('item_type', 'project')
            ->where('item_slug', $slug)
            ->exists();

        return view('projects.show', compact('project', 'isSaved'));
    }

    private function getProjectBySlug($slug)
    {
        $projects = [
            'tax-invoicing' => [
                'slug' => 'tax-invoicing',
                'name' => 'Tax/Invoicing App',
                'icon' => 'fa-receipt',
                'color' => 'success',
                'description' => 'Complete invoicing and tax management solution with PDF generation, invoice tracking, and tax calculations.',
                'features' => ['Invoice Generation', 'Tax Calculations', 'PDF Export', 'Payment Tracking', 'Reports & Analytics'],
                'tech_stack' => ['Laravel', 'Vue.js', 'MySQL', 'PDF Library'],
                'demo_url' => '#',
                'github_url' => '#',
                'download_url' => '#'
            ],
            'restaurant-booking' => [
                'slug' => 'restaurant-booking',
                'name' => 'Restaurant Booking App',
                'icon' => 'fa-utensils',
                'color' => 'danger',
                'description' => 'Web + Mobile restaurant reservation system with real-time table availability and booking management.',
                'features' => ['Table Booking', 'Real-time Availability', 'Mobile App', 'Email Notifications', 'Admin Dashboard'],
                'tech_stack' => ['React', 'Node.js', 'MongoDB', 'React Native'],
                'demo_url' => '#',
                'github_url' => '#',
                'download_url' => '#'
            ],
            'expense-tracker' => [
                'slug' => 'expense-tracker',
                'name' => 'Expense Tracker App',
                'icon' => 'fa-wallet',
                'color' => 'primary',
                'description' => 'Track and manage your expenses efficiently with categories, budgets, and detailed reports.',
                'features' => ['Expense Tracking', 'Category Management', 'Budget Planning', 'Reports', 'Export Data'],
                'tech_stack' => ['Laravel', 'React', 'MySQL', 'Chart.js'],
                'demo_url' => '#',
                'github_url' => '#',
                'download_url' => '#'
            ],
            'todo-list' => [
                'slug' => 'todo-list',
                'name' => 'To-Do List App',
                'icon' => 'fa-list-check',
                'color' => 'info',
                'description' => 'Productive task management application with priorities, deadlines, and collaboration features.',
                'features' => ['Task Management', 'Priorities', 'Deadlines', 'Collaboration', 'Reminders'],
                'tech_stack' => ['Vue.js', 'Laravel', 'MySQL', 'WebSockets'],
                'demo_url' => '#',
                'github_url' => '#',
                'download_url' => '#'
            ],
            'online-teaching' => [
                'slug' => 'online-teaching',
                'name' => 'Online Teaching Platform',
                'icon' => 'fa-chalkboard-teacher',
                'color' => 'warning',
                'description' => 'Complete e-learning management system with courses, assignments, and student progress tracking.',
                'features' => ['Course Management', 'Video Lessons', 'Assignments', 'Progress Tracking', 'Certificates'],
                'tech_stack' => ['Laravel', 'Vue.js', 'MySQL', 'Video Streaming'],
                'demo_url' => '#',
                'github_url' => '#',
                'download_url' => '#'
            ],
            'ceo-dashboard' => [
                'slug' => 'ceo-dashboard',
                'name' => 'CEO Dashboard',
                'icon' => 'fa-chart-line',
                'color' => 'primary',
                'description' => 'Executive analytics and insights dashboard with real-time KPIs and business metrics.',
                'features' => ['Real-time KPIs', 'Business Metrics', 'Data Visualization', 'Custom Reports', 'Export Options'],
                'tech_stack' => ['React', 'Node.js', 'MongoDB', 'D3.js'],
                'demo_url' => '#',
                'github_url' => '#',
                'download_url' => '#'
            ],
            'employee-orientation' => [
                'slug' => 'employee-orientation',
                'name' => 'Employee Orientation App',
                'icon' => 'fa-users',
                'color' => 'success',
                'description' => 'Streamlined employee onboarding and orientation platform with interactive modules.',
                'features' => ['Onboarding Modules', 'Interactive Content', 'Progress Tracking', 'Documentation', 'Quizzes'],
                'tech_stack' => ['Laravel', 'Vue.js', 'MySQL', 'PDF Generator'],
                'demo_url' => '#',
                'github_url' => '#',
                'download_url' => '#'
            ],
        ];

        return $projects[$slug] ?? null;
    }
}
