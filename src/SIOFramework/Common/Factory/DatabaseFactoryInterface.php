<?php


namespace SIOFramework\Common\Factory;


use Slim\Slim;

interface DatabaseFactoryInterface
{
    /**
     * Gets an Object by $id
     *
     * @param $id
     * @return null|object
     */
    public function get($entityFullName, $id);
    /**
     * Gets all the objects matching the query params.
     * Just $entityFullName is mandatory.
     *
     * @param string $entityFullName
     * @param array $criteria
     * @param array $order
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     */
    public function selectAll($entityFullName, $criteria=array(), $order=array(), $limit=NULL, $offset=NULL);

    /**
     * Gets one Object matching the $criteria
     *
     * @param string $entityFullName
     * @param array $criteria
     * @return null|object
     */
    public function selectOne($entityFullName, $criteria);

    /**
     * Persists an object into the database.
     *
     * @param $object
     */
    public function persist($object);

    /**
     * Removes an object from the database
     * @param $object
     */
    public function remove($object);


}