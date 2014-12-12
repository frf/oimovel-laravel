<?php

namespace Base;

use \Amigo as ChildAmigo;
use \AmigoQuery as ChildAmigoQuery;
use \Exception;
use \PDO;
use Map\AmigoTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'amigo' table.
 *
 *
 *
 * @method     ChildAmigoQuery orderByData($order = Criteria::ASC) Order by the data column
 * @method     ChildAmigoQuery orderByIdSorteou($order = Criteria::ASC) Order by the id_sorteou column
 * @method     ChildAmigoQuery orderBySorteado($order = Criteria::ASC) Order by the sorteado column
 * @method     ChildAmigoQuery orderByNome($order = Criteria::ASC) Order by the nome column
 * @method     ChildAmigoQuery orderById($order = Criteria::ASC) Order by the id column
 *
 * @method     ChildAmigoQuery groupByData() Group by the data column
 * @method     ChildAmigoQuery groupByIdSorteou() Group by the id_sorteou column
 * @method     ChildAmigoQuery groupBySorteado() Group by the sorteado column
 * @method     ChildAmigoQuery groupByNome() Group by the nome column
 * @method     ChildAmigoQuery groupById() Group by the id column
 *
 * @method     ChildAmigoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAmigoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAmigoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAmigoQuery leftJoinAmigoRelatedByIdSorteou($relationAlias = null) Adds a LEFT JOIN clause to the query using the AmigoRelatedByIdSorteou relation
 * @method     ChildAmigoQuery rightJoinAmigoRelatedByIdSorteou($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AmigoRelatedByIdSorteou relation
 * @method     ChildAmigoQuery innerJoinAmigoRelatedByIdSorteou($relationAlias = null) Adds a INNER JOIN clause to the query using the AmigoRelatedByIdSorteou relation
 *
 * @method     ChildAmigoQuery leftJoinAmigoRelatedById($relationAlias = null) Adds a LEFT JOIN clause to the query using the AmigoRelatedById relation
 * @method     ChildAmigoQuery rightJoinAmigoRelatedById($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AmigoRelatedById relation
 * @method     ChildAmigoQuery innerJoinAmigoRelatedById($relationAlias = null) Adds a INNER JOIN clause to the query using the AmigoRelatedById relation
 *
 * @method     ChildAmigoQuery leftJoinPresente($relationAlias = null) Adds a LEFT JOIN clause to the query using the Presente relation
 * @method     ChildAmigoQuery rightJoinPresente($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Presente relation
 * @method     ChildAmigoQuery innerJoinPresente($relationAlias = null) Adds a INNER JOIN clause to the query using the Presente relation
 *
 * @method     \AmigoQuery|\PresenteQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAmigo findOne(ConnectionInterface $con = null) Return the first ChildAmigo matching the query
 * @method     ChildAmigo findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAmigo matching the query, or a new ChildAmigo object populated from the query conditions when no match is found
 *
 * @method     ChildAmigo findOneByData(string $data) Return the first ChildAmigo filtered by the data column
 * @method     ChildAmigo findOneByIdSorteou(int $id_sorteou) Return the first ChildAmigo filtered by the id_sorteou column
 * @method     ChildAmigo findOneBySorteado(boolean $sorteado) Return the first ChildAmigo filtered by the sorteado column
 * @method     ChildAmigo findOneByNome(string $nome) Return the first ChildAmigo filtered by the nome column
 * @method     ChildAmigo findOneById(int $id) Return the first ChildAmigo filtered by the id column
 *
 * @method     ChildAmigo[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAmigo objects based on current ModelCriteria
 * @method     ChildAmigo[]|ObjectCollection findByData(string $data) Return ChildAmigo objects filtered by the data column
 * @method     ChildAmigo[]|ObjectCollection findByIdSorteou(int $id_sorteou) Return ChildAmigo objects filtered by the id_sorteou column
 * @method     ChildAmigo[]|ObjectCollection findBySorteado(boolean $sorteado) Return ChildAmigo objects filtered by the sorteado column
 * @method     ChildAmigo[]|ObjectCollection findByNome(string $nome) Return ChildAmigo objects filtered by the nome column
 * @method     ChildAmigo[]|ObjectCollection findById(int $id) Return ChildAmigo objects filtered by the id column
 * @method     ChildAmigo[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AmigoQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\AmigoQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'oimovel', $modelName = '\\Amigo', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAmigoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAmigoQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAmigoQuery) {
            return $criteria;
        }
        $query = new ChildAmigoQuery();
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
     * @return ChildAmigo|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AmigoTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AmigoTableMap::DATABASE_NAME);
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
     * @return ChildAmigo A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT data, id_sorteou, sorteado, nome, id FROM amigo WHERE id = :p0';
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
            /** @var ChildAmigo $obj */
            $obj = new ChildAmigo();
            $obj->hydrate($row);
            AmigoTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildAmigo|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAmigoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AmigoTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAmigoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AmigoTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the data column
     *
     * Example usage:
     * <code>
     * $query->filterByData('2011-03-14'); // WHERE data = '2011-03-14'
     * $query->filterByData('now'); // WHERE data = '2011-03-14'
     * $query->filterByData(array('max' => 'yesterday')); // WHERE data > '2011-03-13'
     * </code>
     *
     * @param     mixed $data The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAmigoQuery The current query, for fluid interface
     */
    public function filterByData($data = null, $comparison = null)
    {
        if (is_array($data)) {
            $useMinMax = false;
            if (isset($data['min'])) {
                $this->addUsingAlias(AmigoTableMap::COL_DATA, $data['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($data['max'])) {
                $this->addUsingAlias(AmigoTableMap::COL_DATA, $data['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmigoTableMap::COL_DATA, $data, $comparison);
    }

    /**
     * Filter the query on the id_sorteou column
     *
     * Example usage:
     * <code>
     * $query->filterByIdSorteou(1234); // WHERE id_sorteou = 1234
     * $query->filterByIdSorteou(array(12, 34)); // WHERE id_sorteou IN (12, 34)
     * $query->filterByIdSorteou(array('min' => 12)); // WHERE id_sorteou > 12
     * </code>
     *
     * @see       filterByAmigoRelatedByIdSorteou()
     *
     * @param     mixed $idSorteou The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAmigoQuery The current query, for fluid interface
     */
    public function filterByIdSorteou($idSorteou = null, $comparison = null)
    {
        if (is_array($idSorteou)) {
            $useMinMax = false;
            if (isset($idSorteou['min'])) {
                $this->addUsingAlias(AmigoTableMap::COL_ID_SORTEOU, $idSorteou['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idSorteou['max'])) {
                $this->addUsingAlias(AmigoTableMap::COL_ID_SORTEOU, $idSorteou['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmigoTableMap::COL_ID_SORTEOU, $idSorteou, $comparison);
    }

    /**
     * Filter the query on the sorteado column
     *
     * Example usage:
     * <code>
     * $query->filterBySorteado(true); // WHERE sorteado = true
     * $query->filterBySorteado('yes'); // WHERE sorteado = true
     * </code>
     *
     * @param     boolean|string $sorteado The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAmigoQuery The current query, for fluid interface
     */
    public function filterBySorteado($sorteado = null, $comparison = null)
    {
        if (is_string($sorteado)) {
            $sorteado = in_array(strtolower($sorteado), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AmigoTableMap::COL_SORTEADO, $sorteado, $comparison);
    }

    /**
     * Filter the query on the nome column
     *
     * Example usage:
     * <code>
     * $query->filterByNome('fooValue');   // WHERE nome = 'fooValue'
     * $query->filterByNome('%fooValue%'); // WHERE nome LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nome The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAmigoQuery The current query, for fluid interface
     */
    public function filterByNome($nome = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nome)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $nome)) {
                $nome = str_replace('*', '%', $nome);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmigoTableMap::COL_NOME, $nome, $comparison);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAmigoQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AmigoTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AmigoTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmigoTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query by a related \Amigo object
     *
     * @param \Amigo|ObjectCollection $amigo The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAmigoQuery The current query, for fluid interface
     */
    public function filterByAmigoRelatedByIdSorteou($amigo, $comparison = null)
    {
        if ($amigo instanceof \Amigo) {
            return $this
                ->addUsingAlias(AmigoTableMap::COL_ID_SORTEOU, $amigo->getId(), $comparison);
        } elseif ($amigo instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AmigoTableMap::COL_ID_SORTEOU, $amigo->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByAmigoRelatedByIdSorteou() only accepts arguments of type \Amigo or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AmigoRelatedByIdSorteou relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAmigoQuery The current query, for fluid interface
     */
    public function joinAmigoRelatedByIdSorteou($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AmigoRelatedByIdSorteou');

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
            $this->addJoinObject($join, 'AmigoRelatedByIdSorteou');
        }

        return $this;
    }

    /**
     * Use the AmigoRelatedByIdSorteou relation Amigo object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AmigoQuery A secondary query class using the current class as primary query
     */
    public function useAmigoRelatedByIdSorteouQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAmigoRelatedByIdSorteou($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AmigoRelatedByIdSorteou', '\AmigoQuery');
    }

    /**
     * Filter the query by a related \Amigo object
     *
     * @param \Amigo|ObjectCollection $amigo  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmigoQuery The current query, for fluid interface
     */
    public function filterByAmigoRelatedById($amigo, $comparison = null)
    {
        if ($amigo instanceof \Amigo) {
            return $this
                ->addUsingAlias(AmigoTableMap::COL_ID, $amigo->getIdSorteou(), $comparison);
        } elseif ($amigo instanceof ObjectCollection) {
            return $this
                ->useAmigoRelatedByIdQuery()
                ->filterByPrimaryKeys($amigo->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAmigoRelatedById() only accepts arguments of type \Amigo or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AmigoRelatedById relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAmigoQuery The current query, for fluid interface
     */
    public function joinAmigoRelatedById($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AmigoRelatedById');

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
            $this->addJoinObject($join, 'AmigoRelatedById');
        }

        return $this;
    }

    /**
     * Use the AmigoRelatedById relation Amigo object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AmigoQuery A secondary query class using the current class as primary query
     */
    public function useAmigoRelatedByIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAmigoRelatedById($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AmigoRelatedById', '\AmigoQuery');
    }

    /**
     * Filter the query by a related \Presente object
     *
     * @param \Presente|ObjectCollection $presente  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmigoQuery The current query, for fluid interface
     */
    public function filterByPresente($presente, $comparison = null)
    {
        if ($presente instanceof \Presente) {
            return $this
                ->addUsingAlias(AmigoTableMap::COL_ID, $presente->getIdUsuario(), $comparison);
        } elseif ($presente instanceof ObjectCollection) {
            return $this
                ->usePresenteQuery()
                ->filterByPrimaryKeys($presente->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPresente() only accepts arguments of type \Presente or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Presente relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAmigoQuery The current query, for fluid interface
     */
    public function joinPresente($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Presente');

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
            $this->addJoinObject($join, 'Presente');
        }

        return $this;
    }

    /**
     * Use the Presente relation Presente object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PresenteQuery A secondary query class using the current class as primary query
     */
    public function usePresenteQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPresente($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Presente', '\PresenteQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAmigo $amigo Object to remove from the list of results
     *
     * @return $this|ChildAmigoQuery The current query, for fluid interface
     */
    public function prune($amigo = null)
    {
        if ($amigo) {
            $this->addUsingAlias(AmigoTableMap::COL_ID, $amigo->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the amigo table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AmigoTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AmigoTableMap::clearInstancePool();
            AmigoTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AmigoTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AmigoTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AmigoTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AmigoTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AmigoQuery
