<?php
namespace Arsors\GlobalContent\Domain\Model;

/*
 * This file is part of the Arsors.GlobalContent package.
 */

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class GlobalContent
{

    /**
     * @var string
     */
    protected $gcKey;

    /**
     * @var string
     */
    protected $gcValue;

    /**
     * @var string
     */
    protected $gcType;

    /**
     * @var string
     */
    protected $gcOrder;

    /**
     * @var string
     */
    protected $gcDimension;


    /**
     * @return string
     */
    public function getGcKey()
    {
        return $this->gcKey;
    }

    /**
     * @param string $gcKey
     * @return void
     */
    public function setGcKey($gcKey)
    {
        $this->gcKey = $gcKey;
    }
    /**
     * @return string
     */
    public function getGcValue()
    {
        return $this->gcValue;
    }

    /**
     * @param string $gcValue
     * @return void
     */
    public function setGcValue($gcValue)
    {
        $this->gcValue = $gcValue;
    }
    /**
     * @return string
     */
    public function getGcType()
    {
        return $this->gcType;
    }

    /**
     * @param string $gcType
     * @return void
     */
    public function setGcType($gcType)
    {
        $this->gcType = $gcType;
    }
    /**
     * @return string
     */
    public function getGcOrder()
    {
        return $this->gcOrder;
    }

    /**
     * @param string $gcOrder
     * @return void
     */
    public function setGcOrder($gcOrder)
    {
        $this->gcOrder = $gcOrder;
    }
    /**
     * @return string
     */
    public function getGcDimension()
    {
        return $this->gcDimension;
    }

    /**
     * @param string $gcDimension
     * @return void
     */
    public function setGcDimension($gcDimension)
    {
        $this->gcDimension = $gcDimension;
    }
}
