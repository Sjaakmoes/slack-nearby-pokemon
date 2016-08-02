<?php
namespace NearbyNotifier;

use NearbyNotifier\Handler\Handler;
use Pokapi\Utility\Geo;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Class BaseNotifier
 *
 * @package NearbyNotifier
 * @author Freek Post <freek@kobalt.blue>
 */
abstract class BaseNotifier
{

    /**
     * @var Handler[]
     */
    protected $handlers = [];

    /**
     * @var array
     */
    protected $steps;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var float
     */
    protected $latitude;

    /**
     * @var float
     */
    protected $longitude;

    /**
     * @var int
     */
    protected $loopInterval = 60000 * 1000; // 60 seconds.

    /**
     * @var int
     */
    protected $stepInterval = 6000 * 1000; // 6 seconds.

    /**
     * BaseNotifier constructor.
     *
     * @param float $latitude
     * @param float $longitude
     * @param int $steps
     * @param float $radius
     */
    public function __construct(float $latitude, float $longitude, int $steps = 5, float $radius = 0.07)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->steps = Geo::generateSteps($this->latitude, $this->longitude, $steps, $radius);
    }

    /**
     * Run the notifier
     *
     * @return void
     */
    abstract public function run();

    /**
     * Run the notifier continously
     *
     * @return void
     */
    abstract public function runContinously();

    /**
     * Overrides the internal steps array
     *
     * @param array $steps
     * @return BaseNotifier
     */
    public function overrideSteps(array $steps) : self
    {
        $this->steps = $steps;
        return $this;
    }

    /**
     * Attach a handler
     *
     * @param Handler $handler
     * @return BaseNotifier
     */
    public function attach(Handler $handler) : self
    {
        $this->handlers[] = $handler;
        return $this;
    }

    /**
     * Set the logger
     *
     * @param LoggerInterface $logger
     *
     * @return BaseNotifier
     */
    public function setLogger(LoggerInterface $logger) : self
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * Set the step interval in milliseconds
     *
     * @param int $interval
     * @return $this
     */
    public function setStepInterval(int $interval)
    {
        $this->stepInterval = round($interval * 1000);
        return $this;
    }

    /**
     * Set the loop interval in milliseconds
     *
     * @param int $interval
     * @return BaseNotifier
     */
    public function setLoopInterval(int $interval) : self
    {
        $this->loopInterval = round($interval * 1000);
        return $this;
    }

    /**
     * Get the logger
     *
     * @return LoggerInterface
     */
    protected function getLogger() : LoggerInterface
    {
        if (!$this->logger instanceof LoggerInterface) {
            $this->logger = new NullLogger();
        }

        return $this->logger;
    }
}
