<?php

namespace ColissimoPickupPoint\Model\Base;

use \Exception;
use \PDO;
use ColissimoPickupPoint\Model\ColissimoPickupPointFreeshipping as ChildColissimoPickupPointFreeshipping;
use ColissimoPickupPoint\Model\ColissimoPickupPointFreeshippingQuery as ChildColissimoPickupPointFreeshippingQuery;
use ColissimoPickupPoint\Model\Map\ColissimoPickupPointFreeshippingTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'colissimo_pickup_point_freeshipping' table.
 *
 *
 *
 * @method     ChildColissimoPickupPointFreeshippingQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildColissimoPickupPointFreeshippingQuery orderByActive($order = Criteria::ASC) Order by the active column
 * @method     ChildColissimoPickupPointFreeshippingQuery orderByFreeshippingFrom($order = Criteria::ASC) Order by the freeshipping_from column
 *
 * @method     ChildColissimoPickupPointFreeshippingQuery groupById() Group by the id column
 * @method     ChildColissimoPickupPointFreeshippingQuery groupByActive() Group by the active column
 * @method     ChildColissimoPickupPointFreeshippingQuery groupByFreeshippingFrom() Group by the freeshipping_from column
 *
 * @method     ChildColissimoPickupPointFreeshippingQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildColissimoPickupPointFreeshippingQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildColissimoPickupPointFreeshippingQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildColissimoPickupPointFreeshipping findOne(ConnectionInterface $con = null) Return the first ChildColissimoPickupPointFreeshipping matching the query
 * @method     ChildColissimoPickupPointFreeshipping findOneOrCreate(ConnectionInterface $con = null) Return the first ChildColissimoPickupPointFreeshipping matching the query, or a new ChildColissimoPickupPointFreeshipping object populated from the query conditions when no match is found
 *
 * @method     ChildColissimoPickupPointFreeshipping findOneById(int $id) Return the first ChildColissimoPickupPointFreeshipping filtered by the id column
 * @method     ChildColissimoPickupPointFreeshipping findOneByActive(boolean $active) Return the first ChildColissimoPickupPointFreeshipping filtered by the active column
 * @method     ChildColissimoPickupPointFreeshipping findOneByFreeshippingFrom(string $freeshipping_from) Return the first ChildColissimoPickupPointFreeshipping filtered by the freeshipping_from column
 *
 * @method     array findById(int $id) Return ChildColissimoPickupPointFreeshipping objects filtered by the id column
 * @method     array findByActive(boolean $active) Return ChildColissimoPickupPointFreeshipping objects filtered by the active column
 * @method     array findByFreeshippingFrom(string $freeshipping_from) Return ChildColissimoPickupPointFreeshipping objects filtered by the freeshipping_from column
 *
 */
abstract class ColissimoPickupPointFreeshippingQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \ColissimoPickupPoint\Model\Base\ColissimoPickupPointFreeshippingQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\ColissimoPickupPoint\\Model\\ColissimoPickupPointFreeshipping', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildColissimoPickupPointFreeshippingQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildColissimoPickupPointFreeshippingQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \ColissimoPickupPoint\Model\ColissimoPickupPointFreeshippingQuery) {
            return $criteria;
        }
        $query = new \ColissimoPickupPoint\Model\ColissimoPickupPointFreeshippingQuery();
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
     * @return ChildColissimoPickupPointFreeshipping|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ColissimoPickupPointFreeshippingTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ColissimoPickupPointFreeshippingTableMap::DATABASE_NAME);
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
     * @return   ChildColissimoPickupPointFreeshipping A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, ACTIVE, FREESHIPPING_FROM FROM colissimo_pickup_point_freeshipping WHERE ID = :p0';
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
            $obj = new ChildColissimoPickupPointFreeshipping();
            $obj->hydrate($row);
            ColissimoPickupPointFreeshippingTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildColissimoPickupPointFreeshipping|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
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
    public function findPks($keys, $con = null)
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
     * @return ChildColissimoPickupPointFreeshippingQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ColissimoPickupPointFreeshippingTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildColissimoPickupPointFreeshippingQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ColissimoPickupPointFreeshippingTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildColissimoPickupPointFreeshippingQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ColissimoPickupPointFreeshippingTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ColissimoPickupPointFreeshippingTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ColissimoPickupPointFreeshippingTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the active column
     *
     * Example usage:
     * <code>
     * $query->filterByActive(true); // WHERE active = true
     * $query->filterByActive('yes'); // WHERE active = true
     * </code>
     *
     * @param     boolean|string $active The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildColissimoPickupPointFreeshippingQuery The current query, for fluid interface
     */
    public function filterByActive($active = null, $comparison = null)
    {
        if (is_string($active)) {
            $active = in_array(strtolower($active), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(ColissimoPickupPointFreeshippingTableMap::ACTIVE, $active, $comparison);
    }

    /**
     * Filter the query on the freeshipping_from column
     *
     * Example usage:
     * <code>
     * $query->filterByFreeshippingFrom(1234); // WHERE freeshipping_from = 1234
     * $query->filterByFreeshippingFrom(array(12, 34)); // WHERE freeshipping_from IN (12, 34)
     * $query->filterByFreeshippingFrom(array('min' => 12)); // WHERE freeshipping_from > 12
     * </code>
     *
     * @param     mixed $freeshippingFrom The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildColissimoPickupPointFreeshippingQuery The current query, for fluid interface
     */
    public function filterByFreeshippingFrom($freeshippingFrom = null, $comparison = null)
    {
        if (is_array($freeshippingFrom)) {
            $useMinMax = false;
            if (isset($freeshippingFrom['min'])) {
                $this->addUsingAlias(ColissimoPickupPointFreeshippingTableMap::FREESHIPPING_FROM, $freeshippingFrom['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($freeshippingFrom['max'])) {
                $this->addUsingAlias(ColissimoPickupPointFreeshippingTableMap::FREESHIPPING_FROM, $freeshippingFrom['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ColissimoPickupPointFreeshippingTableMap::FREESHIPPING_FROM, $freeshippingFrom, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildColissimoPickupPointFreeshipping $colissimoPickupPointFreeshipping Object to remove from the list of results
     *
     * @return ChildColissimoPickupPointFreeshippingQuery The current query, for fluid interface
     */
    public function prune($colissimoPickupPointFreeshipping = null)
    {
        if ($colissimoPickupPointFreeshipping) {
            $this->addUsingAlias(ColissimoPickupPointFreeshippingTableMap::ID, $colissimoPickupPointFreeshipping->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the colissimo_pickup_point_freeshipping table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ColissimoPickupPointFreeshippingTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ColissimoPickupPointFreeshippingTableMap::clearInstancePool();
            ColissimoPickupPointFreeshippingTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildColissimoPickupPointFreeshipping or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildColissimoPickupPointFreeshipping object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ColissimoPickupPointFreeshippingTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ColissimoPickupPointFreeshippingTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        ColissimoPickupPointFreeshippingTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ColissimoPickupPointFreeshippingTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // ColissimoPickupPointFreeshippingQuery
