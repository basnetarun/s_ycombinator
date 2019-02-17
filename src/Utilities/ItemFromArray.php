<?php
namespace Utilities;

trait ItemFromArray
{
    /**
     * @param array $data
     * @return static
     */
    public static function fromArray(array $data)
    {
        $object = new static;
        foreach ($data as $key => $value) {
            if (property_exists(self::class, $key)) {
                $object->$key = $value;
            }
        }
        return $object;
    }
}