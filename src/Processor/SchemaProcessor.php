<?php

namespace Insidion\SwaggerBundle\Processor;


class SchemaProcessor
{
    private $schemaDir;

    public function __construct($rootDir)
    {
        $this->schemaDir = $rootDir . '/swagger/schemas/';
    }

    public function process()
    {
        $schemas = array();
        $files = scandir($this->schemaDir);
        // Filter the . and .. dirs from it.
        array_splice($files, 0, 2);

        foreach ($files as $file) {
            $schemaName = explode(".", $file)[0];
            $filename = $this->schemaDir . $schemaName . '.json';
            $content = json_decode(fread(fopen($filename, 'r'), filesize($filename)));
            $schemas[$schemaName] = $content;
        }

        return $schemas;
    }
}