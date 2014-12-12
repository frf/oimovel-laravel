<?php

namespace Map;

use \Comodo;
use \ComodoQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'comodo' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ComodoTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.ComodoTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'oimovel';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'comodo';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Comodo';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Comodo';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 4;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 4;

    /**
     * the column name for the no_imovel field
     */
    const COL_NO_IMOVEL = 'comodo.no_imovel';

    /**
     * the column name for the tipo_comodo field
     */
    const COL_TIPO_COMODO = 'comodo.tipo_comodo';

    /**
     * the column name for the co_imovel field
     */
    const COL_CO_IMOVEL = 'comodo.co_imovel';

    /**
     * the column name for the co_comodo field
     */
    const COL_CO_COMODO = 'comodo.co_comodo';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('NoImovel', 'TipoComodo', 'CoImovel', 'CoComodo', ),
        self::TYPE_CAMELNAME     => array('noImovel', 'tipoComodo', 'coImovel', 'coComodo', ),
        self::TYPE_COLNAME       => array(ComodoTableMap::COL_NO_IMOVEL, ComodoTableMap::COL_TIPO_COMODO, ComodoTableMap::COL_CO_IMOVEL, ComodoTableMap::COL_CO_COMODO, ),
        self::TYPE_FIELDNAME     => array('no_imovel', 'tipo_comodo', 'co_imovel', 'co_comodo', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('NoImovel' => 0, 'TipoComodo' => 1, 'CoImovel' => 2, 'CoComodo' => 3, ),
        self::TYPE_CAMELNAME     => array('noImovel' => 0, 'tipoComodo' => 1, 'coImovel' => 2, 'coComodo' => 3, ),
        self::TYPE_COLNAME       => array(ComodoTableMap::COL_NO_IMOVEL => 0, ComodoTableMap::COL_TIPO_COMODO => 1, ComodoTableMap::COL_CO_IMOVEL => 2, ComodoTableMap::COL_CO_COMODO => 3, ),
        self::TYPE_FIELDNAME     => array('no_imovel' => 0, 'tipo_comodo' => 1, 'co_imovel' => 2, 'co_comodo' => 3, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('comodo');
        $this->setPhpName('Comodo');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Comodo');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('comodo_co_comodo_seq');
        // columns
        $this->addColumn('no_imovel', 'NoImovel', 'VARCHAR', false, 200, null);
        $this->addColumn('tipo_comodo', 'TipoComodo', 'INTEGER', false, null, null);
        $this->addForeignKey('co_imovel', 'CoImovel', 'BIGINT', 'imovel', 'co_imovel', false, null, null);
        $this->addPrimaryKey('co_comodo', 'CoComodo', 'BIGINT', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Imovel', '\\Imovel', RelationMap::MANY_TO_ONE, array('co_imovel' => 'co_imovel', ), 'CASCADE', 'CASCADE');
        $this->addRelation('Produto', '\\Produto', RelationMap::ONE_TO_MANY, array('co_comodo' => 'co_comodo', ), 'CASCADE', 'CASCADE', 'Produtos');
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to comodo     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        ProdutoTableMap::clearInstancePool();
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 3 + $offset : static::translateFieldName('CoComodo', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 3 + $offset : static::translateFieldName('CoComodo', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 3 + $offset
                : self::translateFieldName('CoComodo', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? ComodoTableMap::CLASS_DEFAULT : ComodoTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Comodo object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ComodoTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ComodoTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ComodoTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ComodoTableMap::OM_CLASS;
            /** @var Comodo $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ComodoTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = ComodoTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ComodoTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Comodo $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ComodoTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(ComodoTableMap::COL_NO_IMOVEL);
            $criteria->addSelectColumn(ComodoTableMap::COL_TIPO_COMODO);
            $criteria->addSelectColumn(ComodoTableMap::COL_CO_IMOVEL);
            $criteria->addSelectColumn(ComodoTableMap::COL_CO_COMODO);
        } else {
            $criteria->addSelectColumn($alias . '.no_imovel');
            $criteria->addSelectColumn($alias . '.tipo_comodo');
            $criteria->addSelectColumn($alias . '.co_imovel');
            $criteria->addSelectColumn($alias . '.co_comodo');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(ComodoTableMap::DATABASE_NAME)->getTable(ComodoTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ComodoTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ComodoTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ComodoTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Comodo or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Comodo object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ComodoTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Comodo) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ComodoTableMap::DATABASE_NAME);
            $criteria->add(ComodoTableMap::COL_CO_COMODO, (array) $values, Criteria::IN);
        }

        $query = ComodoQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ComodoTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ComodoTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the comodo table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ComodoQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Comodo or Criteria object.
     *
     * @param mixed               $criteria Criteria or Comodo object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ComodoTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Comodo object
        }

        if ($criteria->containsKey(ComodoTableMap::COL_CO_COMODO) && $criteria->keyContainsValue(ComodoTableMap::COL_CO_COMODO) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ComodoTableMap::COL_CO_COMODO.')');
        }


        // Set the correct dbName
        $query = ComodoQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ComodoTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ComodoTableMap::buildTableMap();
