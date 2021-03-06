<?php
declare(strict_types=1);
namespace ParagonIE\Ionizer\Filter;

use ParagonIE\Ionizer\InvalidDataException;
use ParagonIE\Ionizer\Util;

/**
 * Class BoolArrayFilter
 * @package ParagonIE\Ionizer\Filter
 */
class BoolArrayFilter extends ArrayFilter
{
    /**
     * @var string
     */
    protected $type = 'bool[]';

    /**
     * Apply all of the callbacks for this filter.
     *
     * @param mixed $data
     * @param int $offset
     * @return mixed
     * @throws \TypeError
     * @throws InvalidDataException
     */
    public function applyCallbacks($data = null, int $offset = 0)
    {
        if ($offset === 0) {
            if (\is_null($data)) {
                return parent::applyCallbacks($data, 0);
            } elseif (!\is_array($data)) {
                throw new \TypeError(
                    \sprintf('Expected an array of booleans (%s).', $this->index)
                );
            }
            /**
             * @var array<mixed, array<mixed, mixed>>
             */
            $data = (array) $data;

            if (!Util::is1DArray($data)) {
                throw new \TypeError(
                    \sprintf('Expected a 1-dimensional array (%s).', $this->index)
                );
            }
            /**
             * @var array<string|int, bool> $data
             * @var int|string $key
             * @var string|int|float|bool|array|null $val
             */
            foreach ($data as $key => $val) {
                if (\is_array($val)) {
                    throw new \TypeError(
                        \sprintf('Expected a 1-dimensional array (%s).', $this->index)
                    );
                }
                $data[$key] = !empty($val);
            }
            return parent::applyCallbacks($data, 0);
        }
        return parent::applyCallbacks($data, $offset);
    }
}
