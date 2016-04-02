<?php


namespace SIOFramework\Common\FileManager;


class ImageFileManager extends FileManager
{

    /**
     * @var array
     */
    protected $imageTypesAllowed = array(
        "image/png",
        "image/jpg",
        "image/jpeg",
    );



    /**
     * @param $fileArray array
     * @param $fileIndex int
     * @return bool
     */
    public function isImageAllowed($fileArray, $fileIndex)
    {
        $format = $this->getFormat($fileArray,$fileIndex);

        if($format==NULL)
            return FALSE;

        foreach($this->imageTypesAllowed as $type)
        {
            if($format == $type)
                return TRUE;
        }

        return FALSE;
    }

    /**
     * @param $fileArray array
     * @param $fileIndex string
     * @return null|string
     */
    public function persistImage($fileArray, $fileIndex)
    {
        if($this->isImageAllowed($fileArray,$fileIndex))
        {
            return $this->persistFile($fileArray,$fileIndex);
        }

        return NULL;
    }


}