<?php

namespace App\Services;

use App\Models\Photo;
use App\Models\Request as RequestModel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Gestion du stockage des photos jointes aux demandes.
 */
class PhotoService
{
    /**
     * Stocke plusieurs photos et les lie à une demande (relation 1-N).
     *
     * Chaque fichier reçoit un nom généré (hashName) pour éviter les
     * collisions et l'exposition du nom d'origine. Disque `public`
     * pour un accès via lien symbolique.
     *
     * @param  array<int, UploadedFile>  $photos
     */
    public function attachMany(RequestModel $requestModel, array $photos): void
    {
        foreach ($photos as $photo) {
            if (! $photo instanceof UploadedFile) {
                continue;
            }

            // Range les fichiers dans storage/app/public/photos
            $path = $photo->store('photos', 'public');

            $requestModel->photos()->create([
                'path' => $path,
            ]);
        }
    }

    /**
     * Supprime physiquement une photo (fichier + ligne BDD).
     */
    public function delete(Photo $photo): void
    {
        Storage::disk('public')->delete($photo->path);
        $photo->delete();
    }
}
