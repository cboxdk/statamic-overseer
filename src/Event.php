<?php

namespace Cboxdk\StatamicOverseer;

use DateTimeInterface;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;
use Statamic\Support\Str;

class Event implements Arrayable, JsonSerializable
{
    /**
     * The entry's type.
     *
     * @var string
     */
    public string $type;

    /**
     * The entry's content.
     *
     * @var array
     */
    public array $content = [];

    /**
     * The DateTime that indicates when the entry was recorded.
     *
     * @var DateTimeInterface
     */
    public DateTimeInterface $recordedAt;

    /**
     * Create a new incoming entry instance.
     *
     * @param  string $type
     * @param array $content
     * @return void
     */
    public function __construct(string $type, array $content)
    {
        $this->recordedAt = now();
        $this->content = $content;
        $this->type($type);
    }

    /**
     * Assign the entry a given type.
     *
     * @return $this
     */
    public function type(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'event' => $this->content,
            'recorded_at' => $this->recordedAt->format('Y-m-d\TH:i:s.u'),
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
