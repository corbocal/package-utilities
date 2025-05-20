<?php

declare(strict_types=1);

namespace Corbocal\Utilities\Tools;

use Symfony\Component\Yaml\Yaml as SymfonyYaml;

class Yaml
{
    private static function getContent(string $pathTofile): string
    {
        $content = file_get_contents($pathTofile);
        if ($content === false) {
            $prefix = __METHOD__ . ":" . __LINE__;
            throw new \InvalidArgumentException(
                "$prefix - Unable to read file $pathTofile.",
                500
            );
        }

        return $content;
    }

    /**
     * parse un fichier YAML et retourne le contenu parsé (tableau)
     *
     * @param string $file /path/to/file
     * @return array<mixed>
     */
    public static function parse(string $file): array
    {
        /** @var array<mixed> */
        $result = SymfonyYaml::parse(self::getContent($file)) ?? [];
        if (!empty($result)) {
            array_walk_recursive($result, function (&$value, $key) {
                if (is_string($value)) {
                    $value = EnvProcessor::resolve(strval($value));
                }
            });
        }

        // yaml_parse_file($file, 0, $ndocs, Yaml::PARSE_OBJECT_FOR_MAP);

        return $result;
    }
}
