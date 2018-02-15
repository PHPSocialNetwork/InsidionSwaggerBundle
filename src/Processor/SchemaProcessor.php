<?php

namespace Insidion\SwaggerBundle\Processor;

/**
 * Class SchemaProcessor
 * @package Insidion\SwaggerBundle\Processor
 */
class SchemaProcessor
{
    /**
     * @var string
     */
    private $schemaDir;

    /**
     * SchemaProcessor constructor.
     * @param string $rootDir
     */
    public function __construct($rootDir)
    {
        $this->schemaDir = $rootDir . '/swagger/schemas/';
    }

    /**
     * @return array
     */
    public function process()
    {
        $schemas = [];
        $files = scandir($this->schemaDir, SCANDIR_SORT_ASCENDING);
        // Filter the . and .. dirs from it.
        array_splice($files, 0, 2);

        foreach ($files as $file) {
            $schemaName = explode(".", $file)[ 0 ];
            $filename = $this->schemaDir . $schemaName . '.json';
            $content = json_decode(fread(fopen($filename, 'r'), filesize($filename)));
            $schemas[ $schemaName ] = $content;
        }

        return $schemas;
    }
}