<?php

namespace Example\Model;

use DataAccess\DataAccess;

/**
 * User controller example
 */
class UserController extends DataAccess{

    /** @var DataAccess|null $db database access object */
    // private $db = null;

    function __construct(){

        parent::__construct("TB_USERS", "ID_USER");
        
    }

}

