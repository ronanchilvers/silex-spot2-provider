<?php

namespace Ronanchilvers\Silex\Application;

trait Spot2Trait
{
    /**
     * Get the spot2 locator
     *
     * @return Spot\Locator
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function spot()
    {
        return $this['spot2.locator'];
    }

    /**
     * Get a mapper for a given entity
     *
     * @param  string $entityName
     * @return Spot\Mapper
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function mapper($entityName)
    {
        if (!class_exists($entityName)) {
            throw new \Exception('Unable to get mapper for unknown entity class ' . $entityName);
        }
        $locator = $this['spot2.locator'];

        return $locator->mapper($entityName);
    }
}
