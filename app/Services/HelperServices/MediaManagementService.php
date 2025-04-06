<?php

namespace App\Services\HelperServices;

use Exception;

class MediaManagementService
{
    /**
     * @throws Exception
     */
    public function handleFile(array $medias): void
    {
        foreach ($medias as $media) {
            if (!isset($media['file'], $media['fileName'], $media['filePath'])) {
                throw new Exception('Invalid media array format');
            }

            $media['file']->move($media['filePath'], $media['fileName']);
        }
    }
}
