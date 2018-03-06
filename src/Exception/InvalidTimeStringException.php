<?php
declare(strict_types=1);

namespace Pauci\DateTime\Exception;

/**
 * Thrown to indicate that the parsed time string is invalid.
 */
class InvalidTimeStringException extends \InvalidArgumentException
{
}
