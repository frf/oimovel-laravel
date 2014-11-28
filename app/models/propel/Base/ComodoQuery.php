<?php

namespace Base;

use \Comodo as ChildComodo;
use \ComodoQuery as ChildComodoQuery;
use \Exception;
use \PDO;
use Map\ComodoTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'comodo' table.
 *
 *
 *
 * @method     ChildComodoQuery orderByNoImovel($order = Criteria::ASC) Order by the no_imovel column
 * @method     ChildComodoQuery orderByTipoComodo($order = Criteria::ASC) Order by the tipo_comodo column
 * @method     ChildComodoQuery orderByCoImovel($order = Criteria::ASC) Order by the co_imovel column
 * @method     ChildComodoQuery orderByCoComodo($order = Criteria::ASC) Order by the co_comodo column
 *
 * @method     ChildComodoQuery groupByNoImovel() Group by the no_imovel column
 * @method     ChildComodoQuery groupByTipoComodo() Group by the tipo_comodo column
 * @method     ChildComodoQuery groupByCoImovel() Group by the co_imovel column
 * @method     ChildComodoQuery groupByCoComodo() Group by the co_comodo column
 *
 * @method     ChildComodoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildComodoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildComodoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildComodoQuery leftJoinImovel($relationAlias = null) Adds a LEFT JOIN clause to the query using the Imovel relation
 * @method     ChildComodoQuery rightJoinImovel($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Imovel relation
 * @method     ChildComodoQuery innerJoinImovel($relationAlias = null) Adds a INNER JOIN clause to the query using the Imovel relation
 *
 * @method     ChildComodoQuery leftJoinProduto($relationAlias = null) Adds a LEFT JOIN clause to the query using the Produto relation
 * @method     ChildComodoQuery rightJoinProduto($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Produto relation
 * @method     ChildComodoQuery innerJoinProduto($relationAlias = null) Adds a INNER JOIN clause to the query using the Produto relation
 *
 * @method     \ImovelQuery|\ProdutoQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildComodo findOne(ConnectionInterface $con = null) Return the first ChildComodo matching the query
 * @method     ChildComodo findOneOrCreate(ConnectionInterface $con = null) Return the first ChildComodo matching the query, or a new ChildComodo object populated from the query conditions when no match is found
 *
 * @method     ChildComodo findOneByNoImovel(string $no_imovel) Return the first ChildComodo filtered by the no_imovel column
 * @method     ChildComodo findOneByTipoComodo(int $tipo_comodo) Return the first ChildComodo filtered by the tipo_comodo column
 * @method     ChildComodo findOneByCoImovel(string $co_imovel) Return the first ChildComodo filtered by the co_imovel column
 * @method     ChildComodo findOneByCoComodo(string $co_comodo) Return the first ChildComodo filtered by the co_comodo column
 *
 * @method     ChildComodo[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildComodo objects based on current ModelCriteria
 * @method     ChildComodo[]|ObjectCollection findByNoImovel(string $no_imovel) Return ChildComodo objects filtered by the no_imovel column
 * @method     ChildComodo[]|ObjectCollection findByTipoComodo(int $tipo_comodo) Return ChildComodo objects filtered by the tipo_comodo column
 * @method     ChildComodo[]|ObjectCollection findByCoImovel(string $co_imovel) Return ChildComodo objects filtered by the co_imovel column
 * @method     ChildComodo[]|ObjectCollection findByCoComodo(string $co_comodo) Return ChildComodo objects filtered by the co_comodo column
 * @method     ChildComodo[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ComodoQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\ComodoQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'oimovel', $modelName = '\\Comodo', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildComodoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildComodoQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildComodoQuery) {
            return $criteria;
        }
        $query = new ChildComodoQuery();
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
     * @return ChildComodo|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ComodoTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ComodoTableMap::DATABASE_NAME);
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
     * @return ChildComodo A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT no_imovel, tipo_comodo, co_imovel, co_comodo FROM comodo WHERE co_comodo = :p0';
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
            /** @var ChildComodo $obj */
            $obj = new ChildComodo();
            $obj->hydrate($row);
            ComodoTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildComodo|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildComodoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ComodoTableMap::COL_CO_COMODO, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildComodoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ComodoTableMap::COL_CO_COMODO, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the no_imovel column
     *
     * Example usage:
     * <code>
     * $query->filterByNoImovel('fooValue');   // WHERE no_imovel = 'fooValue'
     * $query->filterByNoImovel('%fooValue%'); // WHERE no_imovel LIKE '%fooValue%'
     * </code>
     *
     * @param     string $noImovel The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildComodoQuery The current query, for fluid interface
     */
    public function filterByNoImovel($noImovel = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($noImovel)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $noImovel)) {
                $noImovel = str_replace('*', '%', $noImovel);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ComodoTableMap::COL_NO_IMOVEL, $noImovel, $comparison);
    }

    /**
     * Filter the query on the tipo_comodo column
     *
     * Example usage:
     * <code>
     * $query->filterByTipoComodo(1234); // WHERE tipo_comodo = 1234
     * $query->filterByTipoComodo(array(12, 34)); // WHERE tipo_comodo IN (12, 34)
     * $query->filterByTipoComodo(array('min' => 12)); // WHERE tipo_comodo > 12
     * </code>
     *
     * @param     mixed $tipoComodo The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildComodoQuery The current query, for fluid interface
     */
    public function filterByTipoComodo($tipoComodo = null, $comparison = null)
    {
        if (is_array($tipoComodo)) {
            $useMinMax = false;
            if (isset($tipoComodo['min'])) {
                $this->addUsingAlias(ComodoTableMap::COL_TIPO_COMODO, $tipoComodo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($tipoComodo['max'])) {
                $this->addUsingAlias(ComodoTableMap::COL_TIPO_COMODO, $tipoComodo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ComodoTableMap::COL_TIPO_COMODO, $tipoComodo, $comparison);
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
     * @see       filterByImovel()
     *
     * @param     mixed $coImovel The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildComodoQuery The current query, for fluid interface
     */
    public function filterByCoImovel($coImovel = null, $comparison = null)
    {
        if (is_array($coImovel)) {
            $useMinMax = false;
            if (isset($coImovel['min'])) {
                $this->addUsingAlias(ComodoTableMap::COL_CO_IMOVEL, $coImovel['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($coImovel['max'])) {
                $this->addUsingAlias(ComodoTableMap::COL_CO_IMOVEL, $coImovel['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ComodoTableMap::COL_CO_IMOVEL, $coImovel, $comparison);
    }

    /**
     * Filter the query on the co_comodo column
     *
     * Example usage:
     * <code>
     * $query->filterByCoComodo(1234); // WHERE co_comodo = 1234
     * $query->filterByCoComodo(array(12, 34)); // WHERE co_comodo IN (12, 34)
     * $query->filterByCoComodo(array('min' => 12)); // WHERE co_comodo > 12
     * </code>
     *
     * @param     mixed $coComodo The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildComodoQuery The current query, for fluid interface
     */
    public function filterByCoComodo($coComodo = null, $comparison = null)
    {
        if (is_array($coComodo)) {
            $useMinMax = false;
            if (isset($coComodo['min'])) {
                $this->addUsingAlias(ComodoTableMap::COL_CO_COMODO, $coComodo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($coComodo['max'])) {
                $this->addUsingAlias(ComodoTableMap::COL_CO_COMODO, $coComodo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ComodoTableMap::COL_CO_COMODO, $coComodo, $comparison);
    }

    /**
     * Filter the query by a related \Imovel object
     *
     * @param \Imovel|ObjectCollection $imovel The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildComodoQuery The current query, for fluid interface
     */
    public function filterByImovel($imovel, $comparison = null)
    {
        if ($imovel instanceof \Imovel) {
            return $this
                ->addUsingAlias(ComodoTableMap::COL_CO_IMOVEL, $imovel->getCoImovel(), $comparison);
        } elseif ($imovel instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ComodoTableMap::COL_CO_IMOVEL, $imovel->toKeyValue('PrimaryKey', 'CoImovel'), $comparison);
        } else {
            throw new PropelException('filterByImovel() only accepts arguments of type \Imovel or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Imovel relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildComodoQuery The current query, for fluid interface
     */
    public function joinImovel($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Imovel');

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
            $this->addJoinObject($join, 'Imovel');
        }

        return $this;
    }

    /**
     * Use the Imovel relation Imovel object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ImovelQuery A secondary query class using the current class as primary query
     */
    public function useImovelQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinImovel($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Imovel', '\ImovelQuery');
    }

    /**
     * Filter the query by a related \Produto object
     *
     * @param \Produto|ObjectCollection $produto  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildComodoQuery The current query, for fluid interface
     */
    public function filterByProduto($produto, $comparison = null)
    {
        if ($produto instanceof \Produto) {
            return $this
                ->addUsingAlias(ComodoTableMap::COL_CO_COMODO, $produto->getCoComodo(), $comparison);
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
     * @return $this|ChildComodoQuery The current query, for fluid interface
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
     * @param   ChildComodo $comodo Object to remove from the list of results
     *
     * @return $this|ChildComodoQuery The current query, for fluid interface
     */
    public function prune($comodo = null)
    {
        if ($comodo) {
            $this->addUsingAlias(ComodoTableMap::COL_CO_COMODO, $comodo->getCoComodo(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the comodo table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ComodoTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ComodoTableMap::clearInstancePool();
            ComodoTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ComodoTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ComodoTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ComodoTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ComodoTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ComodoQuery
