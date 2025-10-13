<?php

namespace App\Http\Helpers;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;

class DoctrineEntityFactory
{
    /**
     * Create entity manager
     *
     * @return EntityManager
     * @author vduong daiduongptit090@gmail.com
     */
    public function createEntityManager()
    {

        // get configs
        $configDB = $this->getConfig();
        $driver = new AnnotationDriver(new AnnotationReader(), $configDB['paths']);

        $config = Setup::createConfiguration($configDB['isDevMode']);
        // AnnotationRegistry::registerLoader('class_exists');
        // AnnotationRegistry::addAnnotationNamespace('My\Custom\Annotations', 'path/to/my/annotations');
        $config->setMetadataDriverImpl($driver);

        $entityManager = EntityManager::create($configDB['dbParams'], $config);

        return $entityManager;
    }

    /**
     * Prepare config params
     *
     * @return array
     * @author vduong daiduongptit090@gmail.com
     */
    private function getConfig()
    {
        // return [
        //     'paths' => [__DIR__ . '/../Models/Entities'],
        //     'isDevMode' => false,
        //     'dbParams'  => [
        //         'driver'   => 'pdo_mysql',
        //         'user'     => (env('DB_USERNAME')) ? env('DB_USERNAME') : 'root',               //env('DB_USERNAME')
        //         'password' => (env('DB_PASSWORD')) ? env('DB_PASSWORD') : 'tb$aAsiaftp17',                   //env('DB_PASSWORD')
        //         'dbname'   => (env('DB_DATABASE')) ? env('DB_DATABASE') : 'thebo-jam-u-074169',//env('DB_DATABASE'),
        //         'host'     => (env('DB_HOST')) ? env('DB_HOST') : 'localhost',             //env('DB_HOST')
        //         'port'     => (env('DB_PORT')) ? env('DB_PORT') : 3316                         //env('DB_PORT')
        //     ]
        // ];

        return [
            'paths' => [__DIR__ . '/../Models/Entities'],
            'isDevMode' => false,
            'dbParams'  => [
                'driver'   => 'pdo_mysql',
                'user'     => (env('DB_USERNAME')) ? env('DB_USERNAME') : 'root',               //env('DB_USERNAME')
                'password' => (env('DB_PASSWORD')) ? env('DB_PASSWORD') : 'Catch#2023',                   //env('DB_PASSWORD')
                'dbname'   => (env('DB_DATABASE')) ? env('DB_DATABASE') : 'boatshopasia', //env('DB_DATABASE'),
                'host'     => (env('DB_HOST')) ? env('DB_HOST') : '127.0.0.1',             //env('DB_HOST')
                'port'     => (env('DB_PORT')) ? env('DB_PORT') : 3306                         //env('DB_PORT')
            ]
        ];
    }
}
