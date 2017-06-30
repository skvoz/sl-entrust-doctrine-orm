<?php

/**
 * Bridge between zizaco/entrust and Doctrine2
 *
 * @license MIT
 * @package SpotOnLive\EntrustDoctrineORM
 */

namespace SpotOnLive\EntrustDoctrineORM;

use Illuminate\Foundation\Application;
use SpotOnLive\EntrustDoctrineORM\Exceptions;

class EntrustDoctrineORM
{
    /**
     * Laravel application
     *
     * @var Application
     */
    public $app;

    /**
     * Construct EntrustDoctrineORM
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->setDoctrineConfig();
        $this->setEntrustConfig();
    }

    /**
     * Register drivers for EntrustDoctrineORM
     */
    public function setDoctrineConfig()
    {
        /** @var array $config */
        $config = config('doctrine');

        if (is_null($config)) {
            throw new Exceptions\MissingConfigurationException('Please setup the configuration for doctrine');
        }

        $config['metadata'][] = [
            'driver' => 'annotation',
            'namespace' => 'SpotOnLive\EntrustDoctrineORM\Entities',
			'paths' => __dir__,
        ];

        // Save configuration
        config([
            'doctrine' => $config
        ]);
    }

    /**
     * Override entrust configuration
     */
    public function setEntrustConfig()
    {
        config([
            'entrust' => [
                'role' => 'SpotOnLive\EntrustDoctrineORM\Entities\Role',
                'permission' => 'SpotOnLive\EntrustDoctrineORM\Entities\Permission',
            ]
        ]);
    }
}
