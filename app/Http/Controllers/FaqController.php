<?php

namespace App\Http\Controllers;

use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::with('translations')
            ->orderBy('displayOrder')
            ->get()
            ->map(function ($faq) {
                $t = $faq->translation();
                return [
                    'q' => $t->question ?? '',
                    'a' => $t->answer ?? '',
                ];
            });

        return view('faq', ['faqItems' => $faqs]);
    }
}