<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\ToolCatalog;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    public function about(ToolCatalog $catalog)
    {
        return view('pages.about', [
            'categories' => $catalog->categories(),
            'toolsByCat' => array_reduce(array_keys($catalog->categories()), function ($acc, $cat) use ($catalog) {
                $acc[$cat] = $catalog->toolsByCategory($cat);
                return $acc;
            }, []),
        ]);
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function contact(Request $request)
    {
        $success = '';
        $error = '';

        if ($request->isMethod('post')) {
            $data = $request->validate([
                'name' => ['required', 'string', 'max:120'],
                'email' => ['required', 'email', 'max:180'],
                'subject' => ['nullable', 'string', 'max:180'],
                'message' => ['required', 'string', 'max:5000'],
            ]);

            $to = (string) config('nexora.site.email');
            $subject = '[Nexora] ' . trim((string) ($data['subject'] ?? 'Enquiry'));
            $body = "From: {$data['name']} <{$data['email']}>\n\n{$data['message']}";
            $headers = "From: {$data['name']} <{$data['email']}>\r\nReply-To: {$data['email']}";

            // Intentionally uses PHP's mail() (matches legacy behavior).
            // If mail() is not configured, this will fail silently like the old code did.
            @mail($to, $subject, $body, $headers);

            $success = "Message sent! We'll reply within 1–2 business days.";
        }

        return view('pages.contact', [
            'success' => $success,
            'error' => $error,
        ]);
    }
}

