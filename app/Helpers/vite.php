<?php

declare(strict_types=1);

if(!function_exists('vite')) {
    function vite(string $file) : ?string
    {
        try {
            $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true, 512, JSON_THROW_ON_ERROR);

            if($manifest === false) {
                return null;
            }

            if(!empty($manifest[$file]['file'])) {
                return "/build/{$manifest[$file]['file']}";
            }

            return null;
        } catch (Exception) {
            return null;
        }
    }
}

