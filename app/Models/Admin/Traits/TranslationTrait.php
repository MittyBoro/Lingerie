<?php

namespace App\Models\Admin\Traits;


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
