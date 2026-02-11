<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Uploads extends BaseController
{
    public function show($img_path)
    {
        $relative = ltrim((string) $img_path, '/\\');
        $relative = str_replace('..', '', $relative);
        $basePath = rtrim(WRITEPATH . 'uploads', '/\\') . DIRECTORY_SEPARATOR;
        $path = $basePath . $relative;

        if (!is_file($path)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->response
            ->setHeader('Content-Type', mime_content_type($path))
            ->setBody((string) file_get_contents($path));
    }
}
