<?php

namespace App\Services\Provider;

use App\Models\Company;
use App\Models\File;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class CompanyService
{
    public function update(array $data)
    {
        DB::transaction(function () use ($data) {
            $company = auth()->user()->company;

            $company->categories()->sync($data['categories']);

            $this->updatePreview($company, $data['preview'] ?? null, (bool) ($data['preview_remove'] ?? false));

            $this->updateGallery(
                $company,
                $data['gallery_images'] ?? [],
                $data['gallery_images_remove'] ?? []
            );

            $this->updateBusinessHours($company, $data['business_hours'] ?? []);

            $company->update($data);
        });
    }

    public function updatePreview(Company $company, ?UploadedFile $preview, bool $remove = false): void
    {
        if ($remove || $preview) {
            $company->filesByType('preview')->first()?->delete();
        }

        if ($preview) {
            $path = $preview->store('images');

            $company->files()->create([
                'type' => 'preview',
                'path' => $path,
            ]);
        }
    }

    /**
     * @param UploadedFile[] $galleryImages
     * @param int[] $idsToRemove
     */
    public function updateGallery(Company $company, array $galleryImages, array $idsToRemove): void
    {
        if ($idsToRemove) {
            File::whereIn('id', $idsToRemove)->get()->map->delete();
        }

        foreach ($galleryImages as $image) {
            $path = $image->store('images');

            $company->files()->create([
                'type' => 'gallery',
                'path' => $path,
            ]);
        }
    }

    /**
     * @param array<string, array{start: string, end: string}> $businessHours
     */
    public function updateBusinessHours(Company $company, array $businessHours): void
    {

        $company->availabilities()->delete();

        foreach ($businessHours as $day => $time) {
            if (!isset($time['start'], $time['end'])) {
                continue;
            }

            $company->availabilities()->create([
                'weekday' => $day,
                'start' => $time['start'],
                'end' => $time['end'],
            ]);
        }
    }
}
