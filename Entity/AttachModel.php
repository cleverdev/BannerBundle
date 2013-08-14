<?php

namespace cleverdev\BannerBundle\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Abstract class for control attachments model (Image, flash, other files)
 *
 * For upload files in your entity please usage ORM\HasLifecycleCallbacks (preUpdate, prePersist)
 * Example:
 *      // @var string|UploadedFile
 *      protected $image;
 *
 *
 *      // ORM\PreUpdate
 *      // ORM\PrePersist
 *      public function uploadMyFile()
 *      {
 *          $movedPath = $this->uploadFile($this->image);
 *          if ($movedPath !== false) {
 *              $this->image = $movedPath
 *          }
 *      }
 *
 *      // Get upload directory
 *      protected function getUploadPath()
 *      {
 *          return '/my-path'
 *      }
 */
abstract class AttachModel
{
    /**
     * Get upload path
     *
     * @return string
     */
    abstract protected function getUploadPath();

    /**
     * Get web upload path
     *
     * @param null|string $uploadPath
     * @return string
     */
    public function getFullUploadPath($uploadPath = null)
    {
        return '/uploads' . ($uploadPath === null ? $this->getUploadPath() : $uploadPath);
    }

    /**
     * Get root web path
     *
     * @return string
     */
    protected  function getRootWebPath()
    {
        return realpath(__DIR__ . '/../../../web');
    }

    /**
     * Upload file
     *
     * @param string|UploadedFile $file
     * @param string $uploadPath
     * @param string $fileName
     * @return bool|string
     */
    protected function uploadFile($file, $uploadPath = null, $fileName = null)
    {
        if (!$file instanceof UploadedFile) {
            return false;
        }

        if (null === $fileName) {
            if(null === $ext = $file->guessExtension()) {
                $ext = $file->getExtension();
            }


            $fileName = sha1(uniqid(mt_rand(), true));

            if (null !== $ext) {
                $fileName .= '.' . $ext;
            }
        }

        $fullUploadPath = $this->getFullUploadPath($uploadPath);
        $rootPath = $this->getRootWebPath();

        $movePath = $rootPath . $fullUploadPath;

        $file->move($movePath, $fileName);

        return $fullUploadPath . '/' . $fileName;
    }

    /**
     * Remove file
     *
     * @param string $file
     * @return null|bool
     */
    public function removeFile($file)
    {
        if (!$file) {
            return null;
        }

        if (!is_file($file)) {
            if (is_file($this->getRootWebPath() . $file)) {
                $file = $this->getRootWebPath() . $file;
            }
        }

        if (is_file($file)) {
            return  @unlink($file);
        }

        return null;
    }
}