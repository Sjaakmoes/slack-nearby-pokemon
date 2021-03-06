<?php
namespace NearbyNotifier\RouteHandler;

use Pokapi\Request\Position;

/**
 * Class NullHandler
 *
 * @package NearbyNotifier\RouteHandler
 * @author Freek Post <freek@kobalt.blue>
 */
class NullHandler extends RouteHandler
{

    /**
     * Null constructor.
     *
     * @param mixed  $identifier
     */
    public function __construct($identifier = null)
    {
        parent::__construct($identifier);
    }

    /**
     * {@inheritDoc}
     */
    public function walkTo(Position $position)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function start()
    {
    }

    /**
     * {@inheritDoc}
     */
    public function stop()
    {
    }
}
