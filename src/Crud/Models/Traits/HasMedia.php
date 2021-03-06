<?php

namespace Fjord\Crud\Models\Traits;

use Fjord\Crud\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media as SpatieMedia;

trait HasMedia
{
    use InteractsWithMedia;

    /**
     * Media conversions group.
     *
     * @var string
     */
    public $mediaconversions = 'default';

    /**
     * Media relation.
     *
     * @return morphMany
     */
    public function media(): MorphMany
    {
        // Using Fjord media model.
        return $this->morphMany(Media::class, 'model');
    }

    /**
     * Register media conversions.
     *
     * @param SpatieMedia $media
     *
     * @return void
     */
    public function registerMediaConversions(SpatieMedia $media = null): void
    {
        foreach (config('fjord.mediaconversions.default') as $key => $value) {
            $this->addMediaConversion($key)
                ->width($value[0])
                ->height($value[1])
                ->sharpen($value[2]);
        }
    }
}
