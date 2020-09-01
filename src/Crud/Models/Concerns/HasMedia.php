<?php

namespace Fjord\Crud\Models\Concerns;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HasMedia
{
    /**
     * Register media conversions for field.
     *
     * @param Media $media
     *
     * @return void
     */
    public function registerCrudMediaConversions(Media $media = null)
    {
        foreach (config('fjord.mediaconversions.default') as $key => $value) {
            $media = $this->addMediaConversion($key);
            if ($key == 'responsive') {
                $media->withResponsiveImages();
            } else {
                $media->width($value[0])
                    ->height($value[1])
                    ->sharpen($value[2]);
            }
        }
    }
}
