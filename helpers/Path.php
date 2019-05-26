<?php

namespace Chiroruxx\PaizaEnvPhp\Helpers;

class Path
{
    /**
     * Get project base path.
     *
     * @return string
     */
    public static function base(): string
    {
        return realpath(__DIR__ . '/..');
    }

    /**
     * Build path with directory separator.
     *
     * @param string ...$subs
     * @return string
     */
    public static function build(string ...$subs): string
    {
        return implode($subs, DIRECTORY_SEPARATOR);
    }

    /**
     * Get source directory path.
     *
     * @param string[] $subs
     * @return string
     */
    public static function src(string  ...$subs): string
    {
        return self::build(self::base(), 'src', ...$subs);
    }

    /**
     * Get compiled source path.
     *
     * @param string ...$subs
     * @return string
     */
    public static function compiled(string ...$subs): string
    {
        return self::build(self::base(), 'compiled', ...$subs);
    }

    /**
     * Get templates path.
     *
     * @param string ...$subs
     * @return string
     */
    public static function templates(string ...$subs): string
    {
        return self::build(self::base(), 'templates', ...$subs);
    }
}
