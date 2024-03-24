<?php

namespace Javaabu\Helpers\Media;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait UpdateMedia
{
    /**
     * Updates the media collection with given file from request
     *
     * @param $collection
     * @param Request $request
     * @param string $key the file field in the request
     * @return mixed
     */
    public function updateSingleMedia($collection, Request $request, $key = '')
    {
        if (! $key) {
            $key = $collection;
        }

        if ($file = $request->file($key)) {
            //remove the existing file
            $this->clearMediaCollection($collection);

            // add the new file
            return $this->addMedia($file)
                //->usingFileName(Str::slug(Str::random(8)).'.'.$file->guessExtension())
                ->toMediaCollection($collection);
        } elseif ($request->exists($key)) {
            //remove file if the parameter is empty
            $this->clearMediaCollection($collection);
            return 0;
        }

        return false;
    }

    /**
     * Has media collection
     * @param $query
     * @param string $collection
     * @return mixed
     */
    public function scopeHasMedia($query, $collection = '')
    {
        return $query->whereHas('media', function ($query) use ($collection) {
            if ($collection) {
                $query->whereCollectionName($collection);
            }
        });
    }
}
