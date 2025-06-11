<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class FileUploadService
{
    public function uploadBuktiTransfer(UploadedFile $file)
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $hashedName = hash('sha256', $originalName . now()->timestamp);
        $extension = $file->guessExtension();
        
        return $file->storeAs(
            'bukti_transfer/' . date('Y/m/d'),
            $hashedName . '.' . $extension,
            'public'
        );
    }
}