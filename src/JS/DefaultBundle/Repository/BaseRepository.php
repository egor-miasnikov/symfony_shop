<?php

namespace JS\DefaultBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

use JS\PagerBundle\Pager;
use JS\PagerBundle\Adapter\DoctrineOrmAdapter;
use Doctrine\ORM\Query\Expr;

class BaseRepository extends EntityRepository
{
    /**
     * @var QueryBuilder
     */
    private $filter_qb = array();
    static private $filter_id = 0;
    static private $filter_name = 'filter_qb';
    
    /**
     * Adds support for magic finders.
     */
    public function __call($method, $arguments)
    {
        if (0 === strpos($method, 'filterBy'))
        {
            $fieldName = lcfirst(\Doctrine\Common\Util\Inflector::classify(substr($method, 8)));
            return $this->filterBy(array($fieldName => $arguments[0]));
        }
        return parent::__call($method, $arguments);
    }
    
    /**
     * 
     * @param array $array
     * @return BaseRepository
     */
    public function filterBy($array)
    {
        $qb = $this->getFilterQueryBuilder();
    
        foreach ($array as $field => $value)
        {
            $qb->andWhere($this->getFilterName() . '.'.$field.' = :'.$field)->setParameter($field, $value);
        }
        return $this;
    }
    
    /**
     * Create filter QueryBuilder
     * 
     * @return QueryBuilder
     */
    public function getFilterQueryBuilder()
    {
        if (!isset($this->filter_qb[self::$filter_id]))
        {
            $this->filter_qb[self::$filter_id] = $this->createQueryBuilder($this->getFilterName());
        }
        
        return $this->filter_qb[self::$filter_id];
    }
    
    /**
     * 
     * @return string
     */
    public function getFilterName()
    {
        return self::$filter_name.self::$filter_id;
    }
    
    /**
     * Reset filter
     * @return BaseRepository
     */
    public function resetFilter()
    {
        self::$filter_id++;
        return $this;
    }
    
    /**
     * 
     * @param int $limit
     * @return BaseRepository
     */
    public function setFilterLimit($limit)
    {
        $this->getFilterQueryBuilder()->setMaxResults($limit);
        return $this;
    }
    
    /**
     * 
     * @param int $offset
     * @return BaseRepository
     */
    public function setFilterOffset($offset)
    {
        $this->getFilterQueryBuilder()->setFirstResult($offset);
        return $this;
    }
    
    /**
     * @param $order string or array of fields
     * @param $asc_desc string or array of order types
     * 
     * @example ->orderFilter('createdAt', 'DESC')
     * 
     * @return BaseRepository
     */
    public function orderFilter($order, $asc_desc)
    {
        if (!is_array($order)) $order = array($order);
        if (!is_array($asc_desc)) $asc_desc = array($asc_desc);
        
        foreach ($order as $k => $field)
        {
            if (isset($asc_desc[$k])) $a = $asc_desc[$k];
            else $a = $asc_desc[0];
            $this->getFilterQueryBuilder()->addOrderBy($this->getFilterName().'.'.$field, $a);
        }
        return $this;
    }
    /**
     * Get results 
     */
    public function getFilterOneResult()
    {
        return $this->getFilterQueryBuilder()->getQuery()->getOneOrNullResult();
    }
    /**
     * Get results 
     */
    public function getFilterResult($limit = null, $offset = null)
    {
        if ($limit !== null)
        {
            $this->setFilterLimit($limit);
        }
        if ($offset !== null)
        {
            $this->setFilterOffset($offset);
        }
        $res = $this->getFilterQueryBuilder()->getQuery()->getResult();
        
        return $res;
    }
    
    /**
     * Get results array('key' => 'value')
     */
    public function getChoices($key, $value, $limit = null, $offset = null)
    {
        $choices = array();
        $keyMethod = 'get'.\Doctrine\Common\Util\Inflector::classify($key);
        $valueMethod = 'get'.\Doctrine\Common\Util\Inflector::classify($value);
        $res = $this->getFilterResult($limit, $offset);
        foreach ($res as $r)
        {
            $choices[$r->$keyMethod()] = $r->$valueMethod();
        }
        
        return $choices;
    }
    
    /**
     * @return Pager
     */
    public function getPager(QueryBuilder $qb, $page = 1, $limit = 10)
    {
        $adapter = new DoctrineOrmAdapter($qb);
        return new Pager($adapter, array('page' => $page, 'limit' => $limit));
    }
    
    /**
     * @return Pager
     */
    public function getFilterPager($page = 1, $limit = 10)
    {
        return $this->getPager($this->getFilterQueryBuilder(), $page, $limit);
    }
    
    public function isEntityNew($entity)
    {
        return $this->getEntityManager()->getUnitOfWork()->getEntityState($entity) == \Doctrine\ORM\UnitOfWork::STATE_NEW; 
    }
    
    /**
     * 
     * @return integer
     */
    public function count(QueryBuilder $qb = null)
    {
        if (!$qb)
        {
            $qb = $this->getFilterQueryBuilder();
        }
        $qb = clone $qb;
        $root = $qb->getRootAlias();
        return (int) $qb->select('count('.$root.')')->getQuery()->getSingleScalarResult();
    }
    
    /**
     * @param $region mixed regionCode string or Region instance
     * @param $linkType 
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    public function filterBySiteRegion($region, $linkType)
    {
        $region = $this->_getRegion($region);
        
        if (!$this->getClassMetadata()->hasAssociation($linkType))
        {
            throw new \Exception('Entity "'.$this->getEntityName().'" does not have the required association "'.$linkType.'"');
        }
        
        //add criteria
        $qb = $this->getFilterQueryBuilder();
        if (!$qb->getQuery()->contains($this->getFilterName().'.'.$linkType))
        {
            $qb->innerJoin($this->getFilterName().'.'.$linkType, $linkType);
        }       
        $qb->andWhere($linkType.'.region = :site_region')->setParameter('site_region', $region);
        
        return $this;
    }
    
    public function getEntityInstance()
    {
        return $this->getClassMetadata()->newInstance();
    }
}