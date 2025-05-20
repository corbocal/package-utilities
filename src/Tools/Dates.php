<?php

declare(strict_types=1);

namespace Corbocal\Utilities\Tools;

use DateTimeZone;

final class Dates
{
    public const int SECONDS_IN_MINUTE = 60;
    public const int SECONDS_IN_HOUR = 3600;
    public const int SECONDS_IN_DAY = 86400;
    public const int SECONDS_IN_WEEK = 604800;
    public const int SECONDS_IN_YEAR = 31536000;
    public const int MINUTES_IN_HOUR = 60;
    public const int MINUTES_IN_DAY = 1440;
    public const int MINUTES_IN_WEEK = 10080;
    public const int MINUTES_IN_YEAR = 525600;
    public const int HOURS_IN_DAY = 24;
    public const int HOURS_IN_WEEK = 168;
    public const int HOURS_IN_YEAR = 8760;
    public const int DAYS_IN_WEEK = 7;

    private function __construct()
    {
    }

    /**
     * Returns a \DateTimeImmutable object.
     * * if `$date` is __null__ and `$isNullable` __true__, returns __null__
     * * if `$date` is __null__ and `$isNullable` __false__, returns the \DateTimeImmutable of now
     * * if `$date` is a __string__, returns the `\DateTimeImmutable` object with the value of this string
     * * if `$date` is already a `\DateTimeImmutable`, returns it
     * @param \DateTimeImmutable|string|null $date
     * @param bool $isNullable can the date be null?
     * @return ?\DateTimeImmutable
     */
    public static function generate(
        \DateTimeImmutable|string|null $date = null,
        bool $isNullable = false,
        ?\DateTimeZone $timezone = new \DateTimeZone("UTC")
    ): ?\DateTimeImmutable {
        $value = null;

        if ($date === null && !$isNullable) {
            $value = new \DateTimeImmutable("now", $timezone);
        }

        if ($date instanceof \DateTimeImmutable) {
            $value = $date;
        }

        if (\is_string($date)) {
            $value = new \DateTimeImmutable($date, $timezone);
        }

        if ($timezone !== null && $value instanceof \DateTimeImmutable) {
            $value = $value->setTimezone($timezone);
        }

        return $value;
    }

    /**
     * Returns how many days there are between two timestamps (2 decimal)
     * @param int $timestamp1
     * @param int $timestamp2
     * @return float The number of days between the two timestamps, as an absolute value.
     */
    public static function getDaysBetweenTimestamps(int $timestamp1, int $timestamp2): float
    {
        return \round((\abs($timestamp1 - $timestamp2) / self::SECONDS_IN_DAY), 2);
    }

    /**
     * Returns how many hours there are between two timestamps (2 decimal)
     * @param int $timestamp1
     * @param int $timestamp2
     * @return float The number of hours between the two timestamps, as an absolute value.
     */
    public static function getHoursBetweenTimestamps(int $timestamp1, int $timestamp2): float
    {
        return \round((\abs($timestamp1 - $timestamp2) / self::SECONDS_IN_HOUR), 2);
    }

        /**
     * Returns how many hours there are between two timestamps (2 decimal)
     * @param int $timestamp1
     * @param int $timestamp2
     * @return float The number of hours between the two timestamps, as an absolute value.
     */
    public static function getMinutesBetweenTimestamps(int $timestamp1, int $timestamp2): float
    {
        return \round((\abs($timestamp1 - $timestamp2) / self::SECONDS_IN_MINUTE), 2);
    }

}