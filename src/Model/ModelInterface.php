<?php
namespace In2it\Phpunit\Model;

interface ModelInterface
{
    /**
     * ModelInterface constructor.
     *
     * @param \stdClass|null $data If not NULL, it will populate
     * the model at construct
     */
    public function __construct(\stdClass $data = null);

    /**
     * Populates the model with row data as stdClass
     *
     * @param \stdClass $row
     */
    public function populate(\stdClass $row);

    /**
     * Converts this object into an array for easy storage
     *
     * @return array
     */
    public function toArray();
}