<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    // Supprime un fichier téléversé, uniquement s'il se trouve dans public/images
    // (empêche de supprimer un autre fichier du site avec un chemin du type /../.env)
    protected function deletePublicImage($path)
    {
        if (!is_string($path) || $path === '') {
            return;
        }

        $base = realpath(public_path('images'));
        $file = realpath(public_path(ltrim($path, '/')));

        if ($base && $file && str_starts_with($file, $base . DIRECTORY_SEPARATOR) && is_file($file)) {
            @unlink($file);
        }
    }
}
