<?php

namespace App\Models\Concerns;

trait HasTranslations
{
    public function translation($locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return $this->translations
            ->firstWhere('languageCode', $locale)
            ?? $this->translations->firstWhere('languageCode', 'en')
            ?? $this->translations->first();
    }
}