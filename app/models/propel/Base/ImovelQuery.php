<?php

namespace Base;

use \Imovel as ChildImovel;
use \ImovelQuery as ChildImovelQuery;
use \Exception;
use \PDO;
use Map\ImovelTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'imovel' table.
 *
 *
 *
 * @method     ChildImovelQuery orderByTipo($order = Criteria::ASC) Order by the tipo column
 * @method     ChildImovelQuery orderByCoImovel($order = Criteria::ASC) Order by the co_imovel column
 *
 * @method     ChildImovelQuery groupByTipo() Group by the tipo column
 * @method     ChildImovelQuery groupByCoImovel() Group by the co_imovel column
 *
 * @method     ChildImovelQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildImovelQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildImovelQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildImovelQuery leftJoinComodo($relationAlias = null) Adds a LEFT JOIN clause to the query using the Comodo relation
 * @method     ChildImovelQuery rightJoinComodo($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Comodo relation
 * @method     ChildImovelQuery innerJoinComodo($relationAlias = null) Adds a INNER JOIN clause to the query using the Comodo relation
 *
 * @method     ChildImovelQuery leftJoinProduto($relationAlias = null) Adds a LEFT JOIN clause to the query using the Produto relation
 * @method     ChildImovelQuery rightJoinProduto($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Produto relation
 * @method     ChildImovelQuery innerJoinProduto($relationAlias = null) Adds a INNER JOIN clause to the query using the Produto relation
 *
 * @method     \ComodoQuery|\ProdutoQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildImovel findOne(ConnectionInterface $con = null) Return the first ChildImovel matching the query
 * @method     ChildImovel findOneOrCreate(ConnectionInterface $con = null) Return the first ChildImovel matching the query, or a new ChildImovel object populated from the query conditions when no match is found
 *
 * @method     ChildImovel findOneByTipo(int $tipo) Return the first ChildImovel filtered by the tipo column
 * @method     ChildImovel findOneByCoImovel(string $co_imovel) Return the first ChildImovel filtered by the co_imovel column
 *
 * @method     ChildImovel[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildImovel objects based on current ModelCriteria
 * @method     ChildImovel[]|ObjectCollection findByTipo(int $tipo) Return ChildImovel objects filtered by the tipo column
 * @method     ChildImovel[]|ObjectCollection findByCoImovel(string $co_imovel) Return ChildImovel objects filtered by the co_imovel column
 * @method     ChildImovel[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ImovelQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\ImovelQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'oimovel', $modelName = '\\Imovel', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildImovelQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildImovelQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildImovelQuery) {
            return $criteria;
        }
        $query = new ChildImovelQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildImovel|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ImovelTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ImovelTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildImovel A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT tipo, co_imovel FROM imovel WHERE co_imovel = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildImovel $obj */
            $obj = new ChildImovel();
            $obj->hydrate($row);
            ImovelTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildImovel|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildImovelQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ImovelTableMap::COL_CO_IMOVEL, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildImovelQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ImovelTableMap::COL_CO_IMOVEL, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the tipo column
     *
     * Example usage:
     * <code>
     * $query->filterByTipo(1234); // WHERE tipo = 1234
     * $query->filterByTipo(array(12, 34)); // WHERE tipo IN (12, 34)
     * $query->filterByTipo(array('min' => 12)); // WHERE tipo > 12
     * </code>
     *
     * @param     mixed $tipo The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildImovelQuery The current query, for fluid interface
     */
    public function filterByTipo($tipo = null, $comparison = null)
    {
        if (is_array($tipo)) {
            $useMinMax = false;
            if (isset($tipo['min'])) {
                $this->addUsingAlias(ImovelTableMap::COL_TIPO, $tipo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($tipo['max'])) {
                $this->addUsingAlias(ImovelTableMap::COL_TIPO, $tipo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ImovelTableMap::COL_TIPO, $tipo, $comparison);
    }

    /**
     * Filter the query on the co_imovel column
     *
     * Example usage:
     * <code>
     * $query->filterByCoImovel(1234); // WHERE co_imovel = 1234
     * $query->filterByCoImovel(array(12, 34)); // WHERE co_imovel IN (12, 34)
     * $query->filterByCoImovel(array('min' => 12)); // WHERE co_imovel > 12
     * </code>
     *
     * @param     mixed $coImovel The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildImovelQuery The current query, for fluid interface
     */
    public function filterByCoImovel($coImovel = null, $comparison = null)
    {
        if (is_array($coImovel)) {
            $useMinMax = false;
            if (isset($coImovel['min'])) {
                $this->addUsingAlias(ImovelTableMap::COL_CO_IMOVEL, $coImovel['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($coImovel['max'])) {
                $this->addUsingAlias(ImovelTableMap::COL_CO_IMOVEL, $coImovel['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ImovelTableMap::COL_CO_IMOVEL, $coImovel, $comparison);
    }

    /**
     * Filter the query by a related \Comodo object
     *
     * @param \Comodo|ObjectCollection $comodo  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildImovelQuery The current query, for fluid interface
     */
    public function filterByComodo($comodo, $comparison = null)
    {
        if ($comodo instanceof \Comodo) {
            return $this
                ->addUsingAlias(ImovelTableMap::COL_CO_IMOVEL, $comodo->getCoImovel(), $comparison);
        } elseif ($comodo instanceof ObjectCollection) {
            return $this
                ->useComodoQuery()
                ->filterByPrimaryKeys($comodo->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByComodo() only accepts arguments of type \Comodo or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Comodo relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildImovelQuery The current query, for fluid interface
     */
    public function joinComodo($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Comodo');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Comodo');
        }

        return $this;
    }

    /**
     * Use the Comodo relation Comodo object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ComodoQuery A secondary query class using the current class as primary query
     */
    public function useComodoQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinComodo($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Comodo', '\ComodoQuery');
    }

    /**
     * Filter the query by a related \Produto object
     *
     * @param \Produto|ObjectCollection $produto  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildImovelQuery The current query, for fluid interface
     */
    public function filterByProduto($produto, $comparison = null)
    {
        if ($produto instanceof \Produto) {
            return $this
                ->addUsingAlias(ImovelTableMap::COL_CO_IMOVEL, $produto->getCoImovel(), $comparison);
        } elseif ($produto instanceof ObjectCollection) {
            return $this
                ->useProdutoQuery()
                ->filterByPrimaryKeys($produto->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProduto() only accepts arguments of type \Produto or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Produto relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildImovelQuery The current query, for fluid interface
     */
    public function joinProduto($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Produto');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Produto');
        }

        return $this;
    }

    /**
     * Use the Produto relation Produto object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ProdutoQuery A secondary query class using the current class as primary query
     */
    public function useProdutoQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinProduto($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Produto', '\ProdutoQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildImovel $imovel Object to remove from the list of results
     *
     * @return $this|ChildImovelQuery The current query, for fluid interface
     */
    public function prune($imovel = null)
    {
        if ($imovel) {
            $this->addUsingAlias(ImovelTableMap::COL_CO_IMOVEL, $imovel->getCoImovel(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the imovel table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ImovelTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ImovelTableMap::clearInstancePool();
            ImovelTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ImovelTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ImovelTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ImovelTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ImovelTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ImovelQuery
