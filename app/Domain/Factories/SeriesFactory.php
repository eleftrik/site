<?php

namespace LaravelItalia\Domain\Factories;

use Illuminate\Support\Str;
use LaravelItalia\Domain\Series;

/**
 * Class SeriesFactory.
 */
class SeriesFactory
{
    /**
     * @param $title
     * @param $description
     * @param $metadescription
     *
     * @return Series
     */
    public static function createSeries($title, $description, $metadescription)
    {
        $series = new Series();

        $series->title = $title;
        $series->description = $description;
        $series->metadescription = $metadescription;

        $series->is_published = false;
        $series->is_completed = false;

        $series->slug = Str::slug($series->title);

        return $series;
    }
}