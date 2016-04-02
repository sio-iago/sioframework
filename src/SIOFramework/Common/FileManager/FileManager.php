<?php


namespace SIOFramework\Common\FileManager;


class FileManager
{

    // File Metrics
    public static $_KB = 1024;
    public static $_MB = 1048576;
    public static $_GB = 1073741824;

    /**
     * @var string
     */
    protected $uploadDir;


    /**
     * @var int
     */
    protected $maxFileSize;


    /**
     * @param $uploadDir string
     */
    public function __construct($uploadDir, $maxSize = NULL)
    {
        $this->uploadDir = $uploadDir;
        $this->maxFileSize = ($maxSize ? $maxSize : self::$_MB);
    }


    /**
     * @param $fileArray array
     * @param $fileIndex int
     * @return string|NULL
     */
    public function getFormat($fileArray, $fileIndex)
    {
        if(is_array($fileArray) && array_key_exists($fileIndex,$fileArray))
        {
            return $fileArray[$fileIndex]['type'];
        }

        return NULL;
    }


    /**
     * @param $fileArray array
     * @param $fileIndex int
     * @return bool
     */
    public function isFileSizeValid($fileArray, $fileIndex)
    {
        if(is_array($fileArray) && array_key_exists($fileIndex,$fileArray))
        {
            return $fileArray[$fileIndex]['size'] <= $this->maxFileSize;
        }

        return FALSE;
    }


    /**
     * @param $fileArray array
     * @param $fileIndex string
     * @return null|string
     */
    public function persistFile($fileArray, $fileIndex)
    {
        if($this->isFileSizeValid($fileArray,$fileIndex))
        {
            $fileName = uniqid().$fileArray[$fileIndex]['name'];

            $filePath = $this->uploadDir . '/' . $fileName;

            if(move_uploaded_file($fileArray[$fileIndex]['tmp_name'],$filePath))
            {
                return $fileName;
            }
        }

        return NULL;
    }

    /**
     * Remove the file from the system.
     * @param $fileName
     * @throws \Exception
     */
    public function unlinkFile($fileName)
    {
        $filePath = $this->uploadDir . '/' . $fileName;

        if(file_exists($filePath))
            unlink($filePath);
        else
            throw new \Exception('File does not exists');
    }

}