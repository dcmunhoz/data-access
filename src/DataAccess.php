<?php

namespace DataAccess;

/**
 * Class to control the access and manipulation of databases.
 */
class DataAccess {

    /** @var string|null $entity Name of database entity to manipulate. */
    private $entity = null;

    /** @var string|null $primary Name of primary field of entity. */
    private $primary = null;

    /** 
     * 
     * Creates a new object of class.
     * 
     * @param string $entity Name of database entity to manipulate.
     * @param string|null $primary Name of primary field of entity.
     * 
     */
    function __construct(string $entity, string $primary){

        
    }

}