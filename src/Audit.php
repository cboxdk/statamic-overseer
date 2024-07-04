<?php

namespace Cboxdk\StatamicOverseer;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

class Audit implements Arrayable, JsonSerializable
{
    /**
     * The audit message.
     */
    public string $message;

    /**
     * Properties for the audit message
     */
    public ?array $properties;

    public ?string $site;

    public ?string $model_type;

    public ?string $model_handle;

    public ?string $model_id;

    /**
     * Create a new audit
     *
     * @return void
     */
    public function __construct(
        string $message,
        ?array $properties = null,
        $site = null,
        $model_type = null,
        $model_handle = null,
        $model_id = null,
    ) {
        $this->setMessage($message);
        $this->setProperties($properties);
        $this->setSite($site);
        $this->setModelType($model_type);
        $this->setModelHandle($model_handle);
        $this->setModelId($model_id);
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): Audit
    {
        $this->message = $message;

        return $this;
    }

    public function getProperties(): ?array
    {
        return $this->properties;
    }

    public function setProperties(?array $properties): Audit
    {
        $this->properties = $properties;

        return $this;
    }

    public function getSite(): ?string
    {
        return $this->site;
    }

    public function setSite(?string $site): Audit
    {
        $this->site = $site;

        return $this;
    }

    public function getModelType(): ?string
    {
        return $this->model_type;
    }

    public function setModelType(?string $model_type): Audit
    {
        $this->model_type = $model_type;

        return $this;
    }

    public function getModelHandle(): ?string
    {
        return $this->model_handle;
    }

    public function setModelHandle(?string $model_handle): Audit
    {
        $this->model_handle = $model_handle;

        return $this;
    }

    public function getModelId(): ?string
    {
        return $this->model_id;
    }

    public function setModelId(?string $model_id): Audit
    {
        $this->model_id = $model_id;

        return $this;
    }

    public function toArray()
    {
        return [
            'message' => $this->getMessage(),
            'properties' => $this->getProperties(),
            'model_type' => $this->getModelType(),
            'model_handle' => $this->getModelHandle(),
            'model_id' => $this->getModelId(),
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
