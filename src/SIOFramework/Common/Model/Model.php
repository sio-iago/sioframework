<?php


namespace SIOFramework\Common\Model;


use Doctrine\Common\Collections\ArrayCollection;

abstract class Model
{
    /**
     * Hydrates the entity.
     * @param array $array
     */
    public function hydrate(array $array)
    {
        $setPrefix = 'set';

        foreach ($array as $key => $val)
        {
            $setter = $setPrefix.ucfirst($key);

            if(method_exists($this,$setter))
            {
                $this->$setter($val);
            }
        }
    }


    public function toArray()
    {
        $parameters = array();

        foreach(get_object_vars($this) as $key=>$var)
        {
            if(is_array($this->$key))
                $parameters[$key] = $this->objectArrayToArray($this->$key);
            else if(is_object($this->$key) && get_class($this->$key) == get_class(new ArrayCollection()))
                $parameters[$key] = $this->objectArrayToArray($this->$key->toArray());
            else if(is_object($this->$key) && method_exists($this->$key,'toArray'))
                $parameters[$key] = $this->$key->toArray();
            else
                $parameters[$key] = $this->$key;
        }

        return $parameters;
    }

    protected function objectArrayToArray(array $objectArray)
    {
        $parameters = array();

        foreach($objectArray as $obj)
        {
            if(is_object($obj) && method_exists($obj,'toArray'))
                $parameters[] = $obj->toArray();
            else
                $parameters[] = $obj;
        }

        return $parameters;
    }
}