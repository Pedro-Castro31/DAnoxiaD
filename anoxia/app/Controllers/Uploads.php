<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Uploads extends BaseController
{
    public function show($img_path = null)
    {
        $segments = $this->request->getUri()->getSegments();
        $relativeFromUri = '';
        if (count($segments) > 1) {
            $relativeFromUri = implode('/', array_slice($segments, 1));
        }

        $relative = $relativeFromUri !== '' ? $relativeFromUri : trim((string) $img_path);
        $relative = urldecode($relative);
        $relative = str_replace('\\', '/', $relative);
        $relative = ltrim($relative, '/');
        $relative = str_replace('..', '', $relative);
        $basePath = rtrim(WRITEPATH . 'uploads', '/\\') . DIRECTORY_SEPARATOR;
        $path = $basePath . str_replace('/', DIRECTORY_SEPARATOR, $relative);

        if (! is_file($path)) {
            log_message(
                'debug',
                '[UPLOADS] file not found requested="{requested}" resolved="{resolved}"',
                ['requested' => (string) ($relativeFromUri !== '' ? $relativeFromUri : $img_path), 'resolved' => $path]
            );
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->response
            ->setHeader('Content-Type', mime_content_type($path))
            ->setBody((string) file_get_contents($path));
    }
}
