php-named-time-offset
=====================

PHP library for named time offsets

## What This Is
A library providing a mapping from named time offsets (e.g., Pacific Standard
Time, Pacific Daylight Time) to integer IDs for more efficient storing and
to their common abbreviations for convenient display.

## What This Is Not
This is not a library for determining timezones or handling their changing
offsets. It does not have any dependency on the [timezone database] [tzdata].

## Why This Is Needed
It may be desirable to allow a user to enter time in a specific time offset
and remember which offset for later display. Although abbreviations are the
most common way for people to work with offsets, they are not unique. The
full offset names are unique, but they are verbose and inefficient for storage.


[tzdata]: http://en.wikipedia.org/wiki/Tz_database
