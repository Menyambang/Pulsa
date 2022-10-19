<?php


namespace App\Controllers;


use Bepsvpt\Blurhash\BlurHash;
use kornrunner\Blurhash\Blurhash as KornBlurHash;
use CodeIgniter\Config\Config;
use App\Controllers\BaseController;
use App\Libraries\MyDownloadResponse;

class File extends BaseController
{
    const NOT_EXIST_IMAGE = WRITEPATH . "404.jpg";

    public function get($dir, $filename)
    {
        $type = $this->request->getGet('type') ?? 'file';
        $size = $this->request->getGet('size');

        $filename = basename($filename);
        $path = $fullpath = Config::get("App")->uploadPath . "$dir" . DIRECTORY_SEPARATOR;
        $fullpath = $path . $filename;

        if (file_exists($fullpath)) {
            $file = new \CodeIgniter\Files\File($fullpath);
            // Resize Image
            if (!empty($size)) {
                $realFileName = explode('.', $file->getFilename())[0];
                $fileName = $realFileName . '_' . $size . '.' . $file->getExtension();
                $newCompressPath = $path . $realFileName;
                $newCompressPathFile = $newCompressPath . DIRECTORY_SEPARATOR . $fileName;

                // Create folder thumbnail
                if (!is_dir($newCompressPath)) {
                    mkdir($newCompressPath, 0777, true);
                }

                // Compress if file not exist
                if (!file_exists($newCompressPathFile)) {
                    $image = \Config\Services::image()
                        ->withFile($file)
                        ->resize($size, $size, true, 'height')
                        ->save($newCompressPathFile);
                }

                $fullpath = $newCompressPathFile;
            }
        }

        if ($type == 'file') {
            //Sanitasi filename dari backslash folder
            if (file_exists($fullpath)) {
                $file = new \CodeIgniter\Files\File($fullpath);
                if (!in_array($file->getMimeType(), [
                    'image/png', 'image/jpg', 'image/jpeg', 'application/pdf'
                ])) {
                    return $this->response->setJSON([
                        'code' => 403,
                        'message' => 'Tipe File dilarang'
                    ]);
                }

                $download = new MyDownloadResponse($fullpath, true);
                return $download->notForce();
            } else {
                $filename = self::NOT_EXIST_IMAGE;
                if (file_exists($filename)) {
                    $mime = mime_content_type($filename);
                    header('Content-Length: ' . filesize($filename));
                    header("Content-Type: $mime");
                    header('Content-Disposition: inline; filename="' . $filename . '";');
                    readfile($filename);
                    exit();
                }

                return $this->response->setJSON([
                    'code' => 404,
                    'message' => 'File not found'
                ]);
            }
        } else if ($type == 'blurhash') {
            // Blurhash image
            if (file_exists($fullpath)) {
                $file = new \CodeIgniter\Files\File($fullpath);
                $image = imagecreatefromstring(file_get_contents($file));
                $blurHash = new BlurHash(4, 3);
                echo $blurHash->encode($image);
            } else {
                $image = imagecreatefromstring(file_get_contents(self::NOT_EXIST_IMAGE));
                $blurHash = new BlurHash(4, 3);
                echo $blurHash->encode($image);
            }
        } else if ($type == 'blur') {
            if (file_exists($fullpath)) {
                $this->blurImage($fullpath);
            } else {
                $this->blurImage((self::NOT_EXIST_IMAGE));
            }
        }
    }

    /**
     * Experimental
     * 
     * Deleted all file not used from database
     *
     * @param [type] $dir
     * @return void
     */
    public function checkNotUsedFile($dir)
    {
        $usedFile = [];

        if (!empty($usedFile)) {
            $path  = Config::get("App")->uploadPath . "$dir" . DIRECTORY_SEPARATOR;
            $files = scandir($path);
            $mergePath = array_flip($files);
            unset($mergePath['.'], $mergePath['..']);

            foreach ($mergePath as $fileName => $value) {
                if (!preg_grep('~' . $fileName . '~', $usedFile)) {
                    try {
                        unlink($path . $fileName);
                    } catch (\Throwable $th) {
                        $this->deleteDirectory($path . $fileName);
                    }
                }
            }
        }
    }

    /**
     * Recursive Delete Directory
     *
     * @param [type] $dir
     * @return void
     */
    private function deleteDirectory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }

        return rmdir($dir);
    }

    /**
     * Blur Image
     *
     * @param [type] $path
     * @return void
     */
    private function blurImage($path)
    {
        header("Content-Type: image/png");
        $file = new \CodeIgniter\Files\File($path);
        $image = imagecreatefromstring(file_get_contents($file));

        /* Get original image size */
        list($w, $h) = getimagesize($file);

        /* Create array with width and height of down sized images */
        $size = array(
            'sm' => array('w' => intval($w / 4), 'h' => intval($h / 4)),
            'md' => array('w' => intval($w / 2), 'h' => intval($h / 2))
        );

        /* Scale by 25% and apply Gaussian blur */
        $sm = imagecreatetruecolor($size['sm']['w'], $size['sm']['h']);
        imagecopyresampled($sm, $image, 0, 0, 0, 0, $size['sm']['w'], $size['sm']['h'], $w, $h);

        for ($x = 1; $x <= 40; $x++) {
            imagefilter($sm, IMG_FILTER_GAUSSIAN_BLUR, 999);
        }

        imagefilter($sm, IMG_FILTER_SMOOTH, 99);
        imagefilter($sm, IMG_FILTER_BRIGHTNESS, 10);

        /* Scale result by 200% and blur again */
        $md = imagecreatetruecolor($size['md']['w'], $size['md']['h']);
        imagecopyresampled($md, $sm, 0, 0, 0, 0, $size['md']['w'], $size['md']['h'], $size['sm']['w'], $size['sm']['h']);
        imagedestroy($sm);

        for ($x = 1; $x <= 25; $x++) {
            imagefilter($md, IMG_FILTER_GAUSSIAN_BLUR, 999);
        }

        imagefilter($md, IMG_FILTER_SMOOTH, 99);
        imagefilter($md, IMG_FILTER_BRIGHTNESS, 10);

        /* Scale result back to original size */
        imagecopyresampled($image, $md, 0, 0, 0, 0, $w, $h, $size['md']['w'], $size['md']['h']);
        imagedestroy($md);

        imagepng($image);
        imagedestroy($image);
        exit;
    }
}
