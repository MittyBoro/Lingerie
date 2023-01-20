<?php

namespace App\Models\Traits\Admin;


trait TranslationTrait
{
    protected function saveTranslations($translation)
    {
        collect($translation)
            ->each(fn($item) =>
                    isset($item['id']) ?
                        $this->translations()->find($item['id'])->update($item) :
                        $this->translations()->create($item)
            );
    }
}
