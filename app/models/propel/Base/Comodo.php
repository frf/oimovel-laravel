<?php

namespace Base;

use \Comodo as ChildComodo;
use \ComodoQuery as ChildComodoQuery;
use \Imovel as ChildImovel;
use \ImovelQuery as ChildImovelQuery;
use \Produto as ChildProduto;
use \ProdutoQuery as ChildProdutoQuery;
use \Exception;
use \PDO;
use Map\ComodoTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'comodo' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Comodo implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\ComodoTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the no_imovel field.
     * @var        string
     */
    protected $no_imovel;

    /**
     * The value for the tipo_comodo field.
     * @var        int
     */
    protected $tipo_comodo;

    /**
     * The value for the co_imovel field.
     * @var        string
     */
    protected $co_imovel;

    /**
     * The value for the co_comodo field.
     * @var        string
     */
    protected $co_comodo;

    /**
     * @var        ChildImovel
     */
    protected $aImovel;

    /**
     * @var        ObjectCollection|ChildProduto[] Collection to store aggregation of ChildProduto objects.
     */
    protected $collProdutos;
    protected $collProdutosPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildProduto[]
     */
    protected $produtosScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Comodo object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Comodo</code> instance.  If
     * <code>obj</code> is an instance of <code>Comodo</code>, delegates to
     * <code>equals(Comodo)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Comodo The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [no_imovel] column value.
     *
     * @return string
     */
    public function getNoImovel()
    {
        return $this->no_imovel;
    }

    /**
     * Get the [tipo_comodo] column value.
     *
     * @return int
     */
    public function getTipoComodo()
    {
        return $this->tipo_comodo;
    }

    /**
     * Get the [co_imovel] column value.
     *
     * @return string
     */
    public function getCoImovel()
    {
        return $this->co_imovel;
    }

    /**
     * Get the [co_comodo] column value.
     *
     * @return string
     */
    public function getCoComodo()
    {
        return $this->co_comodo;
    }

    /**
     * Set the value of [no_imovel] column.
     *
     * @param  string $v new value
     * @return $this|\Comodo The current object (for fluent API support)
     */
    public function setNoImovel($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->no_imovel !== $v) {
            $this->no_imovel = $v;
            $this->modifiedColumns[ComodoTableMap::COL_NO_IMOVEL] = true;
        }

        return $this;
    } // setNoImovel()

    /**
     * Set the value of [tipo_comodo] column.
     *
     * @param  int $v new value
     * @return $this|\Comodo The current object (for fluent API support)
     */
    public function setTipoComodo($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->tipo_comodo !== $v) {
            $this->tipo_comodo = $v;
            $this->modifiedColumns[ComodoTableMap::COL_TIPO_COMODO] = true;
        }

        return $this;
    } // setTipoComodo()

    /**
     * Set the value of [co_imovel] column.
     *
     * @param  string $v new value
     * @return $this|\Comodo The current object (for fluent API support)
     */
    public function setCoImovel($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->co_imovel !== $v) {
            $this->co_imovel = $v;
            $this->modifiedColumns[ComodoTableMap::COL_CO_IMOVEL] = true;
        }

        if ($this->aImovel !== null && $this->aImovel->getCoImovel() !== $v) {
            $this->aImovel = null;
        }

        return $this;
    } // setCoImovel()

    /**
     * Set the value of [co_comodo] column.
     *
     * @param  string $v new value
     * @return $this|\Comodo The current object (for fluent API support)
     */
    public function setCoComodo($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->co_comodo !== $v) {
            $this->co_comodo = $v;
            $this->modifiedColumns[ComodoTableMap::COL_CO_COMODO] = true;
        }

        return $this;
    } // setCoComodo()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ComodoTableMap::translateFieldName('NoImovel', TableMap::TYPE_PHPNAME, $indexType)];
            $this->no_imovel = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ComodoTableMap::translateFieldName('TipoComodo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->tipo_comodo = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ComodoTableMap::translateFieldName('CoImovel', TableMap::TYPE_PHPNAME, $indexType)];
            $this->co_imovel = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ComodoTableMap::translateFieldName('CoComodo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->co_comodo = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 4; // 4 = ComodoTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Comodo'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aImovel !== null && $this->co_imovel !== $this->aImovel->getCoImovel()) {
            $this->aImovel = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ComodoTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildComodoQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aImovel = null;
            $this->collProdutos = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Comodo::setDeleted()
     * @see Comodo::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ComodoTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildComodoQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ComodoTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                ComodoTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aImovel !== null) {
                if ($this->aImovel->isModified() || $this->aImovel->isNew()) {
                    $affectedRows += $this->aImovel->save($con);
                }
                $this->setImovel($this->aImovel);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->produtosScheduledForDeletion !== null) {
                if (!$this->produtosScheduledForDeletion->isEmpty()) {
                    \ProdutoQuery::create()
                        ->filterByPrimaryKeys($this->produtosScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->produtosScheduledForDeletion = null;
                }
            }

            if ($this->collProdutos !== null) {
                foreach ($this->collProdutos as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[ComodoTableMap::COL_CO_COMODO] = true;
        if (null !== $this->co_comodo) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ComodoTableMap::COL_CO_COMODO . ')');
        }
        if (null === $this->co_comodo) {
            try {
                $dataFetcher = $con->query("SELECT nextval('comodo_co_comodo_seq')");
                $this->co_comodo = $dataFetcher->fetchColumn();
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', 0, $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ComodoTableMap::COL_NO_IMOVEL)) {
            $modifiedColumns[':p' . $index++]  = 'no_imovel';
        }
        if ($this->isColumnModified(ComodoTableMap::COL_TIPO_COMODO)) {
            $modifiedColumns[':p' . $index++]  = 'tipo_comodo';
        }
        if ($this->isColumnModified(ComodoTableMap::COL_CO_IMOVEL)) {
            $modifiedColumns[':p' . $index++]  = 'co_imovel';
        }
        if ($this->isColumnModified(ComodoTableMap::COL_CO_COMODO)) {
            $modifiedColumns[':p' . $index++]  = 'co_comodo';
        }

        $sql = sprintf(
            'INSERT INTO comodo (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'no_imovel':
                        $stmt->bindValue($identifier, $this->no_imovel, PDO::PARAM_STR);
                        break;
                    case 'tipo_comodo':
                        $stmt->bindValue($identifier, $this->tipo_comodo, PDO::PARAM_INT);
                        break;
                    case 'co_imovel':
                        $stmt->bindValue($identifier, $this->co_imovel, PDO::PARAM_INT);
                        break;
                    case 'co_comodo':
                        $stmt->bindValue($identifier, $this->co_comodo, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ComodoTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getNoImovel();
                break;
            case 1:
                return $this->getTipoComodo();
                break;
            case 2:
                return $this->getCoImovel();
                break;
            case 3:
                return $this->getCoComodo();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Comodo'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Comodo'][$this->hashCode()] = true;
        $keys = ComodoTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getNoImovel(),
            $keys[1] => $this->getTipoComodo(),
            $keys[2] => $this->getCoImovel(),
            $keys[3] => $this->getCoComodo(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aImovel) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'imovel';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'imovel';
                        break;
                    default:
                        $key = 'Imovel';
                }

                $result[$key] = $this->aImovel->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collProdutos) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'produtos';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'produtos';
                        break;
                    default:
                        $key = 'Produtos';
                }

                $result[$key] = $this->collProdutos->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Comodo
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ComodoTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Comodo
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setNoImovel($value);
                break;
            case 1:
                $this->setTipoComodo($value);
                break;
            case 2:
                $this->setCoImovel($value);
                break;
            case 3:
                $this->setCoComodo($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = ComodoTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setNoImovel($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setTipoComodo($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setCoImovel($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setCoComodo($arr[$keys[3]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Comodo The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ComodoTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ComodoTableMap::COL_NO_IMOVEL)) {
            $criteria->add(ComodoTableMap::COL_NO_IMOVEL, $this->no_imovel);
        }
        if ($this->isColumnModified(ComodoTableMap::COL_TIPO_COMODO)) {
            $criteria->add(ComodoTableMap::COL_TIPO_COMODO, $this->tipo_comodo);
        }
        if ($this->isColumnModified(ComodoTableMap::COL_CO_IMOVEL)) {
            $criteria->add(ComodoTableMap::COL_CO_IMOVEL, $this->co_imovel);
        }
        if ($this->isColumnModified(ComodoTableMap::COL_CO_COMODO)) {
            $criteria->add(ComodoTableMap::COL_CO_COMODO, $this->co_comodo);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildComodoQuery::create();
        $criteria->add(ComodoTableMap::COL_CO_COMODO, $this->co_comodo);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getCoComodo();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->getCoComodo();
    }

    /**
     * Generic method to set the primary key (co_comodo column).
     *
     * @param       string $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setCoComodo($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getCoComodo();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Comodo (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setNoImovel($this->getNoImovel());
        $copyObj->setTipoComodo($this->getTipoComodo());
        $copyObj->setCoImovel($this->getCoImovel());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getProdutos() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProduto($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setCoComodo(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Comodo Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildImovel object.
     *
     * @param  ChildImovel $v
     * @return $this|\Comodo The current object (for fluent API support)
     * @throws PropelException
     */
    public function setImovel(ChildImovel $v = null)
    {
        if ($v === null) {
            $this->setCoImovel(NULL);
        } else {
            $this->setCoImovel($v->getCoImovel());
        }

        $this->aImovel = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildImovel object, it will not be re-added.
        if ($v !== null) {
            $v->addComodo($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildImovel object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildImovel The associated ChildImovel object.
     * @throws PropelException
     */
    public function getImovel(ConnectionInterface $con = null)
    {
        if ($this->aImovel === null && (($this->co_imovel !== "" && $this->co_imovel !== null))) {
            $this->aImovel = ChildImovelQuery::create()->findPk($this->co_imovel, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aImovel->addComodos($this);
             */
        }

        return $this->aImovel;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Produto' == $relationName) {
            return $this->initProdutos();
        }
    }

    /**
     * Clears out the collProdutos collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addProdutos()
     */
    public function clearProdutos()
    {
        $this->collProdutos = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collProdutos collection loaded partially.
     */
    public function resetPartialProdutos($v = true)
    {
        $this->collProdutosPartial = $v;
    }

    /**
     * Initializes the collProdutos collection.
     *
     * By default this just sets the collProdutos collection to an empty array (like clearcollProdutos());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProdutos($overrideExisting = true)
    {
        if (null !== $this->collProdutos && !$overrideExisting) {
            return;
        }
        $this->collProdutos = new ObjectCollection();
        $this->collProdutos->setModel('\Produto');
    }

    /**
     * Gets an array of ChildProduto objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildComodo is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildProduto[] List of ChildProduto objects
     * @throws PropelException
     */
    public function getProdutos(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collProdutosPartial && !$this->isNew();
        if (null === $this->collProdutos || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collProdutos) {
                // return empty collection
                $this->initProdutos();
            } else {
                $collProdutos = ChildProdutoQuery::create(null, $criteria)
                    ->filterByComodo($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collProdutosPartial && count($collProdutos)) {
                        $this->initProdutos(false);

                        foreach ($collProdutos as $obj) {
                            if (false == $this->collProdutos->contains($obj)) {
                                $this->collProdutos->append($obj);
                            }
                        }

                        $this->collProdutosPartial = true;
                    }

                    return $collProdutos;
                }

                if ($partial && $this->collProdutos) {
                    foreach ($this->collProdutos as $obj) {
                        if ($obj->isNew()) {
                            $collProdutos[] = $obj;
                        }
                    }
                }

                $this->collProdutos = $collProdutos;
                $this->collProdutosPartial = false;
            }
        }

        return $this->collProdutos;
    }

    /**
     * Sets a collection of ChildProduto objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $produtos A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildComodo The current object (for fluent API support)
     */
    public function setProdutos(Collection $produtos, ConnectionInterface $con = null)
    {
        /** @var ChildProduto[] $produtosToDelete */
        $produtosToDelete = $this->getProdutos(new Criteria(), $con)->diff($produtos);


        $this->produtosScheduledForDeletion = $produtosToDelete;

        foreach ($produtosToDelete as $produtoRemoved) {
            $produtoRemoved->setComodo(null);
        }

        $this->collProdutos = null;
        foreach ($produtos as $produto) {
            $this->addProduto($produto);
        }

        $this->collProdutos = $produtos;
        $this->collProdutosPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Produto objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Produto objects.
     * @throws PropelException
     */
    public function countProdutos(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collProdutosPartial && !$this->isNew();
        if (null === $this->collProdutos || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProdutos) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getProdutos());
            }

            $query = ChildProdutoQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByComodo($this)
                ->count($con);
        }

        return count($this->collProdutos);
    }

    /**
     * Method called to associate a ChildProduto object to this object
     * through the ChildProduto foreign key attribute.
     *
     * @param  ChildProduto $l ChildProduto
     * @return $this|\Comodo The current object (for fluent API support)
     */
    public function addProduto(ChildProduto $l)
    {
        if ($this->collProdutos === null) {
            $this->initProdutos();
            $this->collProdutosPartial = true;
        }

        if (!$this->collProdutos->contains($l)) {
            $this->doAddProduto($l);
        }

        return $this;
    }

    /**
     * @param ChildProduto $produto The ChildProduto object to add.
     */
    protected function doAddProduto(ChildProduto $produto)
    {
        $this->collProdutos[]= $produto;
        $produto->setComodo($this);
    }

    /**
     * @param  ChildProduto $produto The ChildProduto object to remove.
     * @return $this|ChildComodo The current object (for fluent API support)
     */
    public function removeProduto(ChildProduto $produto)
    {
        if ($this->getProdutos()->contains($produto)) {
            $pos = $this->collProdutos->search($produto);
            $this->collProdutos->remove($pos);
            if (null === $this->produtosScheduledForDeletion) {
                $this->produtosScheduledForDeletion = clone $this->collProdutos;
                $this->produtosScheduledForDeletion->clear();
            }
            $this->produtosScheduledForDeletion[]= $produto;
            $produto->setComodo(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Comodo is new, it will return
     * an empty collection; or if this Comodo has previously
     * been saved, it will retrieve related Produtos from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Comodo.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildProduto[] List of ChildProduto objects
     */
    public function getProdutosJoinImovel(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildProdutoQuery::create(null, $criteria);
        $query->joinWith('Imovel', $joinBehavior);

        return $this->getProdutos($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aImovel) {
            $this->aImovel->removeComodo($this);
        }
        $this->no_imovel = null;
        $this->tipo_comodo = null;
        $this->co_imovel = null;
        $this->co_comodo = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collProdutos) {
                foreach ($this->collProdutos as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collProdutos = null;
        $this->aImovel = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ComodoTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
