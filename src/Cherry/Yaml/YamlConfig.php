<?php

declare(strict_types=1);

namespace Cherry\Yaml;

use Symfony\Component\Yaml\Exception\ParseException;
use Cherry\Base\Exception\BaseException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class YamlConfig
 * 
 * @package Cherry
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 */
class YamlConfig
{
    /**
     * Checks if a file exists.
     *
     * @param string $filename The name of the file to check.
     * @throws BaseException If the file does not exist.
     */
    private function fileExists($filename)
    {
        if (!file_exists($filename)) {
            throw new BaseException("{$filename} does not exist");
        }
    }

    /**
     * Retrieves the content of a YAML file based on the provided filename.
     *
     * @param string $yamlFile The name of the YAML file to retrieve.
     * @return mixed The parsed content of the YAML file.
     */
    public function getYaml(string $yamlFile)
    {
        foreach (glob(CONFIG_DIR . DS . '*.yaml') as $file) {
            $this->fileExists($file);
            $parts = parse_url($file);
            $path = $parts['path'];
            if (strpos($path, $yamlFile) !== false) {
                return Yaml::parseFile($file);
            }
        }
    }

    public static function file(string $yamlFile)
    {
        return (new YamlConfig())->getYaml($yamlFile);
    }
}
