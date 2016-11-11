<?php

/**
 * 純粋な配列
 */
class Collection extends SplFixedArray implements JsonSerializable {
    function offsetSet($offset, $value) {
        if ($offset === null) {
            $offset = count($this);
            $this->setSize($offset + 1);
        }
        return parent::offsetSet($offset, $value);
    }

    public function jsonSerialize() {
        return $this->toArray();
    }
}