<?php

namespace App\Http\Controllers;

use App\Models\Testimony;

class TestimonialController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();

        $testimonials = Testimony::with('translations')
            ->approved()
            ->orderByDesc('date')
            ->get()
            ->map(function ($t) use ($locale) {
                $content = optional(
                    $t->translations->firstWhere('languageCode', $locale)
                )->content ?? '';

                return [
                    'name'    => $t->authorName,
                    'role'    => $t->authorRole,
                    'text'    => $content,
                    'photo'   => $t->photo,
                ];
            });

        return view('testimonials', ['testimonials' => $testimonials]);
    }
}