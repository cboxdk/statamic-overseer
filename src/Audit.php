<?php

namespace Cboxdk\StatamicOverseer;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;
use Statamic\Support\Str;

class Audit implements Arrayable, JsonSerializable
{

    /**
     * The audit message.
     *
     * @var string
     */
    public $message;

    /**
     * Properties for the audit message
     *
     * @var array
     */
    public array $properties = [];

    /**
     * Create a new audit
     *
     * @param  string  $message
     * @return void
     */
    public function __construct(string $message, array $properties = [])
    {
        $this->message = $message;
        $this->properties = $properties;
    }

    public function toArray()
    {
        return [
            'message' => $this->message,
            'properties' => $this->properties,
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
