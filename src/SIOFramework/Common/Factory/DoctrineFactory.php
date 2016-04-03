<?php

namespace SIOFramework\Common\Factory;


use Doctrine\ORM\EntityManager;
use Slim\Slim;

abstract class DoctrineFactory implements DatabaseFactoryInterface
{

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * DoctrineFactory constructor.
     * @param Slim $app
     */
    public function __construct(Slim $app)
    {
        $this->entityManager = $app->container->get('orm');
    }

    /**
     * Gets an Object by $id
     *
     * @param $id
     * @return null|object
     */
    public function get($entityFullName, $id)
    {
        return $this->entityManager->find($entityFullName,$id);
    }

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
    public function selectAll($entityFullName, $criteria=array(), $order=array(), $limit=NULL, $offset=NULL)
    {
        $repository = $this->entityManager->getRepository($entityFullName);

        $data = $repository->findBy($criteria,$order, $limit, $offset);

        return $data;
    }

    /**
     * Gets one Object matching the $criteria
     *
     * @param string $entityFullName
     * @param array $criteria
     * @return null|object
     */
    public function selectOne($entityFullName, $criteria)
    {
        $repository = $this->entityManager->getRepository($entityFullName);

        $data = $repository->findOneBy($criteria);

        return $data;
    }

    /**
     * Persists an object into the database.
     *
     * 1) If object has getId method and getId() != NULL,
     *    updates the object
     *
     * 2) If getId() == NULL, inserts the object
     *
     * @param $object
     */
    public function persist($object)
    {
        $em = $this->entityManager;

        if(is_object($object) && method_exists($object,'getId') && $object->getId()!=NULL)
            $em->merge($object);
        else
            $em->persist($object);

        $em->flush();
    }

    /**
     * Removes an object from the database
     * @param $object
     */
    public function remove($object)
    {
        $em = $this->entityManager;

        if(is_object($object))
            $em->remove($object);

        $em->flush();
    }


}