<?php

namespace Base;

use \Produto as ChildProduto;
use \ProdutoQuery as ChildProdutoQuery;
use \Exception;
use \PDO;
use Map\ProdutoTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'produto' table.
 *
 *
 *
 * @method     ChildProdutoQuery orderByCoImovel($order = Criteria::ASC) Order by the co_imovel column
 * @method     ChildProdutoQuery orderByCoComodo($order = Criteria::ASC) Order by the co_comodo column
 * @method     ChildProdutoQuery orderByVlProduto($order = Criteria::ASC) Order by the vl_produto column
 * @method     ChildProdutoQuery orderByNoProduto($order = Criteria::ASC) Order by the no_produto column
 * @method     ChildProdutoQuery orderByCoProduto($order = Criteria::ASC) Order by the co_produto column
 *
 * @method     ChildProdutoQuery groupByCoImovel() Group by the co_imovel column
 * @method     ChildProdutoQuery groupByCoComodo() Group by the co_comodo column
 * @method     ChildProdutoQuery groupByVlProduto() Group by the vl_produto column
 * @method     ChildProdutoQuery groupByNoProduto() Group by the no_produto column
 * @method     ChildProdutoQuery groupByCoProduto() Group by the co_produto column
 *
 * @method     ChildProdutoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildProdutoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildProdutoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildProdutoQuery leftJoinComodo($relationAlias = null) Adds a LEFT JOIN clause to the query using the Comodo relation
 * @method     ChildProdutoQuery rightJoinComodo($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Comodo relation
 * @method     ChildProdutoQuery innerJoinComodo($relationAlias = null) Adds a INNER JOIN clause to the query using the Comodo relation
 *
 * @method     ChildProdutoQuery leftJoinImovel($relationAlias = null) Adds a LEFT JOIN clause to the query using the Imovel relation
 * @method     ChildProdutoQuery rightJoinImovel($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Imovel relation
 * @method     ChildProdutoQuery innerJoinImovel($relationAlias = null) Adds a INNER JOIN clause to the query using the Imovel relation
 *
 * @method     \ComodoQuery|\ImovelQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildProduto findOne(ConnectionInterface $con = null) Return the first ChildProduto matching the query
 * @method     ChildProduto findOneOrCreate(ConnectionInterface $con = null) Return the first ChildProduto matching the query, or a new ChildProduto object populated from the query conditions when no match is found
 *
 * @method     ChildProduto findOneByCoImovel(string $co_imovel) Return the first ChildProduto filtered by the co_imovel column
 * @method     ChildProduto findOneByCoComodo(string $co_comodo) Return the first ChildProduto filtered by the co_comodo column
 * @method     ChildProduto findOneByVlProduto(string $vl_produto) Return the first ChildProduto filtered by the vl_produto column
 * @method     ChildProduto findOneByNoProduto(string $no_produto) Return the first ChildProduto filtered by the no_produto column
 * @method     ChildProduto findOneByCoProduto(string $co_produto) Return the first ChildProduto filtered by the co_produto column
 *
 * @method     ChildProduto[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildProduto objects based on current ModelCriteria
 * @method     ChildProduto[]|ObjectCollection findByCoImovel(string $co_imovel) Return ChildProduto objects filtered by the co_imovel column
 * @method     ChildProduto[]|ObjectCollection findByCoComodo(string $co_comodo) Return ChildProduto objects filtered by the co_comodo column
 * @method     ChildProduto[]|ObjectCollection findByVlProduto(string $vl_produto) Return ChildProduto objects filtered by the vl_produto column
 * @method     ChildProduto[]|ObjectCollection findByNoProduto(string $no_produto) Return ChildProduto objects filtered by the no_produto column
 * @method     ChildProduto[]|ObjectCollection findByCoProduto(string $co_produto) Return ChildProduto objects filtered by the co_produto column
 * @method     ChildProduto[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ProdutoQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\ProdutoQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'oimovel', $modelName = '\\Produto', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildProdutoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildProdutoQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildProdutoQuery) {
            return $criteria;
        }
        $query = new ChildProdutoQuery();
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
     * @return ChildProduto|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProdutoTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ProdutoTableMap::DATABASE_NAME);
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
     * @return ChildProduto A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT co_imovel, co_comodo, vl_produto, no_produto, co_produto FROM produto WHERE co_produto = :p0';
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
            /** @var ChildProduto $obj */
            $obj = new ChildProduto();
            $obj->hydrate($row);
            ProdutoTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildProduto|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildProdutoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProdutoTableMap::COL_CO_PRODUTO, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildProdutoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProdutoTableMap::COL_CO_PRODUTO, $keys, Criteria::IN);
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
     * @return $this|ChildProdutoQuery The current query, for fluid interface
     */
    public function filterByCoImovel($coImovel = null, $comparison = null)
    {
        if (is_array($coImovel)) {
            $useMinMax = false;
            if (isset($coImovel['min'])) {
                $this->addUsingAlias(ProdutoTableMap::COL_CO_IMOVEL, $coImovel['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($coImovel['max'])) {
                $this->addUsingAlias(ProdutoTableMap::COL_CO_IMOVEL, $coImovel['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProdutoTableMap::COL_CO_IMOVEL, $coImovel, $comparison);
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
     * @see       filterByComodo()
     *
     * @param     mixed $coComodo The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProdutoQuery The current query, for fluid interface
     */
    public function filterByCoComodo($coComodo = null, $comparison = null)
    {
        if (is_array($coComodo)) {
            $useMinMax = false;
            if (isset($coComodo['min'])) {
                $this->addUsingAlias(ProdutoTableMap::COL_CO_COMODO, $coComodo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($coComodo['max'])) {
                $this->addUsingAlias(ProdutoTableMap::COL_CO_COMODO, $coComodo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProdutoTableMap::COL_CO_COMODO, $coComodo, $comparison);
    }

    /**
     * Filter the query on the vl_produto column
     *
     * Example usage:
     * <code>
     * $query->filterByVlProduto('fooValue');   // WHERE vl_produto = 'fooValue'
     * $query->filterByVlProduto('%fooValue%'); // WHERE vl_produto LIKE '%fooValue%'
     * </code>
     *
     * @param     string $vlProduto The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProdutoQuery The current query, for fluid interface
     */
    public function filterByVlProduto($vlProduto = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($vlProduto)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $vlProduto)) {
                $vlProduto = str_replace('*', '%', $vlProduto);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProdutoTableMap::COL_VL_PRODUTO, $vlProduto, $comparison);
    }

    /**
     * Filter the query on the no_produto column
     *
     * Example usage:
     * <code>
     * $query->filterByNoProduto('fooValue');   // WHERE no_produto = 'fooValue'
     * $query->filterByNoProduto('%fooValue%'); // WHERE no_produto LIKE '%fooValue%'
     * </code>
     *
     * @param     string $noProduto The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProdutoQuery The current query, for fluid interface
     */
    public function filterByNoProduto($noProduto = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($noProduto)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $noProduto)) {
                $noProduto = str_replace('*', '%', $noProduto);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProdutoTableMap::COL_NO_PRODUTO, $noProduto, $comparison);
    }

    /**
     * Filter the query on the co_produto column
     *
     * Example usage:
     * <code>
     * $query->filterByCoProduto(1234); // WHERE co_produto = 1234
     * $query->filterByCoProduto(array(12, 34)); // WHERE co_produto IN (12, 34)
     * $query->filterByCoProduto(array('min' => 12)); // WHERE co_produto > 12
     * </code>
     *
     * @param     mixed $coProduto The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProdutoQuery The current query, for fluid interface
     */
    public function filterByCoProduto($coProduto = null, $comparison = null)
    {
        if (is_array($coProduto)) {
            $useMinMax = false;
            if (isset($coProduto['min'])) {
                $this->addUsingAlias(ProdutoTableMap::COL_CO_PRODUTO, $coProduto['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($coProduto['max'])) {
                $this->addUsingAlias(ProdutoTableMap::COL_CO_PRODUTO, $coProduto['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProdutoTableMap::COL_CO_PRODUTO, $coProduto, $comparison);
    }

    /**
     * Filter the query by a related \Comodo object
     *
     * @param \Comodo|ObjectCollection $comodo The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildProdutoQuery The current query, for fluid interface
     */
    public function filterByComodo($comodo, $comparison = null)
    {
        if ($comodo instanceof \Comodo) {
            return $this
                ->addUsingAlias(ProdutoTableMap::COL_CO_COMODO, $comodo->getCoComodo(), $comparison);
        } elseif ($comodo instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProdutoTableMap::COL_CO_COMODO, $comodo->toKeyValue('PrimaryKey', 'CoComodo'), $comparison);
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
     * @return $this|ChildProdutoQuery The current query, for fluid interface
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
     * Filter the query by a related \Imovel object
     *
     * @param \Imovel|ObjectCollection $imovel The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildProdutoQuery The current query, for fluid interface
     */
    public function filterByImovel($imovel, $comparison = null)
    {
        if ($imovel instanceof \Imovel) {
            return $this
                ->addUsingAlias(ProdutoTableMap::COL_CO_IMOVEL, $imovel->getCoImovel(), $comparison);
        } elseif ($imovel instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProdutoTableMap::COL_CO_IMOVEL, $imovel->toKeyValue('PrimaryKey', 'CoImovel'), $comparison);
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
     * @return $this|ChildProdutoQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildProduto $produto Object to remove from the list of results
     *
     * @return $this|ChildProdutoQuery The current query, for fluid interface
     */
    public function prune($produto = null)
    {
        if ($produto) {
            $this->addUsingAlias(ProdutoTableMap::COL_CO_PRODUTO, $produto->getCoProduto(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the produto table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProdutoTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ProdutoTableMap::clearInstancePool();
            ProdutoTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ProdutoTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ProdutoTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ProdutoTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ProdutoTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ProdutoQuery
