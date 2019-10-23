<?php

namespace DataAccess;

/**
 * 
 * Class DataAccess
 * 
 * Control the access and manipulation of databases
 * 
 */
class DataAccess {

    /** @var PDO $con PDO connection object */
    private $con = null;

    /** @var string|null $entity Name of database entity to manipulate. */
    private $entity = "";

    /** @var string|null $primary Name of primary field of entity. */
    private $primary = "";

    /** @var array|null $terms Terms to search */
    private $terms = null;

    /** @var string|null $query Query to execute */
    private $query = "";

    /** @var array $data Getters and Setters data */
    private $attributes = null;

    /** 
     * 
     * Constructor
     * 
     * @param string $entity Name of database entity to manipulate.
     * @param string|null $primary Name of primary field of entity.
     * 
     */
    public function __construct(string $entity, string $primary)
    {

        if (!empty($entity) && !empty($primary)){
            $this->entity  = $entity;
            $this->primary = $primary;      

            try {
                
                $dsn = DATA_ACCESS['driver'] . ":host=". DATA_ACCESS['host'] . 
                ";port=". DATA_ACCESS['port'] . ";dbname=" . DATA_ACCESS['dbname'];
                

                $this->con = new \PDO($dsn, DATA_ACCESS['user'], DATA_ACCESS['password'], DATA_ACCESS['options']);

            } catch (PDOException $e) {
    
                var_dump($e->getMessage());
    
            } catch (Exception $e) {
                var_dump($e->getMessage());
            }
        }

    }

    /**
     * 
     * Set value on $attributes
     * 
     * @param string $name Setter param name
     * @param string $value Setter param value
     * 
     */
    public function __set(string $name, $value) 
    {

        if (empty($this->attributes)) {

            $this->attributes = new \stdClass();

        }

        $this->attributes->{$name} = $value;

    }
    
    /**
     * 
     * Get a value from $attributes
     * 
     * @param string $name Getter param name
     * 
     */
    public function __get(string $name) 
    {

        return ($this->attributes->{$name} ?? null);

    }

    /**
     * 
     * Return all attributes
     * 
     */
    public function getData()
    {

        return $this->attributes;

    }

    /**
     * 
     * Set all attributes
     * 
     * @param array $attributes Attributes to set
     * 
     */
    public function setData($attributes)
    {

        foreach ($attributes as $key => $value) {
            
            $this->{$key} = $value;

        }

    }

    /**
     * 
     * Return data of searched id
     * 
     * @param string $id Id to search
     * 
     */
    public function findById(string $id)
    {

        $stmt = $this->con->prepare("SELECT * FROM {$this->entity} WHERE {$this->primary} = :id");
        $stmt->bindParam(":id", $id);

        $stmt->execute();

        $result = $stmt->fetch();

        if (!$result) {
            return null;
        }

        $this->setData($result);

    }

    /**
     * 
     * Execute a raw query
     * 
     * @param string $query Query to execute
     * @param array|null $params Params to bind on query
     * 
     */
    public function raw(string $query, array $params = null): ?array
    {

        $stmt = $this->con->prepare($query);

        if (!empty($params)) {

            $this->bindParams($stmt, $params);

        }

        $result = $stmt->execute();

        $queryAction = \explode(" ", $query)[0];
        switch (\strtoupper($queryAction)) {
            case 'INSERT':
            case 'UPDATE':
                return $result;
            break;
            case 'SELECT':
                $result = $stmt->fetchAll();
                return $result;
            break;
        }

    }

    /**
     * 
     * Return all results of table
     * 
     * @param string $columns Columns to show on result
     */
    public function find(string $columns = "*"): DataAccess 
    {

        if (!empty($columns)) {
            $this->query = "select {$columns} from {$this->entity} ";

            return $this;
        }

        $err = \json_encode(["error"=>true, "errMsg"=>"columns can't be null or empty"]);
        die($err);

    }

    /**
     * Bind query params 
     * 
     * @param \PDOStatement $stmt Statement
     * @param array $params Params to bind
     * 
     */
    private function bindParams(\PDOStatement $stmt,array $params):void 
    {
        foreach( $params as $key => $value){
            $this->bindParam($stmt, $key, $value);
        }
    }

    /**
     * 
     * Bind param on statement
     * 
     * @param \PDOStatement $stmt Statement
     * @param string $key Key to bind
     * @param string $value Value to bind on key
     * 
     */
    private function bindParam(\PDOStatement $stmt, string $key, string $value): void
    {
        $stmt->bindParam($key, $value);
    }
    
    /**
     * 
     * Fetch the query
     * 
     */
    public function fetch($all = false)
    {

        if (!$this->query){

            die("No query found !");
        }

        $stmt = $this->con->prepare($this->query);

        if (!empty($this->terms)) {
            $this->bindParams($stmt, $this->terms);
        }

        $stmt->execute();

        $fetch = ($all) ? 'fetchAll' : 'fetch';

        $result = $stmt->{"$fetch"}();

        return $result;

    }
}