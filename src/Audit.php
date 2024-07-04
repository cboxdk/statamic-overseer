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

    public ?string $collection;

    public ?string $taxonomy;

    public ?string $global;

    public ?string $navigation;

    public ?string $asset_container;

    public ?string $tree;

    public ?string $roles;

    public ?string $groups;

    public ?string $entry_id;

    public ?string $term_handle;

    public ?string $asset_id;

    public ?string $global_set;

    public ?string $site;

    /**
     * Create a new audit
     *
     * @return void
     */
    public function __construct(
        string $message,
        ?array $properties = null,
        $site = null,
        $collection = null,
        $taxonomy = null,
        $global = null,
        $navigation = null,
        $asset_container = null,
        $tree = null,
        $roles = null,
        $groups = null,
        $entry_id = null,
        $term_handle = null,
        $asset_id = null,
        $global_set = null
    ) {
        $this->setMessage($message);
        $this->setProperties($properties);
        $this->setSite($site);
        $this->setCollection($collection);
        $this->setTaxonomy($taxonomy);
        $this->setGlobal($global);
        $this->setNavigation($navigation);
        $this->setAssetContainer($asset_container);
        $this->setTree($tree);
        $this->setRoles($roles);
        $this->setGroups($groups);
        $this->setEntryId($entry_id);
        $this->setTermHandle($term_handle);
        $this->setAssetId($asset_id);
        $this->setGlobalSet($global_set);
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

    public function getCollection(): ?string
    {
        return $this->collection;
    }

    public function setCollection(?string $collection): Audit
    {
        $this->collection = $collection;

        return $this;
    }

    public function getTaxonomy(): ?string
    {
        return $this->taxonomy;
    }

    public function setTaxonomy(?string $taxonomy): Audit
    {
        $this->taxonomy = $taxonomy;

        return $this;
    }

    public function getGlobal(): ?string
    {
        return $this->global;
    }

    public function setGlobal(?string $global): Audit
    {
        $this->global = $global;

        return $this;
    }

    public function getNavigation(): ?string
    {
        return $this->navigation;
    }

    public function setNavigation(?string $navigation): Audit
    {
        $this->navigation = $navigation;

        return $this;
    }

    public function getAssetContainer(): ?string
    {
        return $this->asset_container;
    }

    public function setAssetContainer(?string $asset_container): Audit
    {
        $this->asset_container = $asset_container;

        return $this;
    }

    public function getTree(): ?string
    {
        return $this->tree;
    }

    public function setTree(?string $tree): Audit
    {
        $this->tree = $tree;

        return $this;
    }

    public function getRoles(): ?string
    {
        return $this->roles;
    }

    public function setRoles(?string $roles): Audit
    {
        $this->roles = $roles;

        return $this;
    }

    public function getGroups(): ?string
    {
        return $this->groups;
    }

    public function setGroups(?string $groups): Audit
    {
        $this->groups = $groups;

        return $this;
    }

    public function getEntryId(): ?string
    {
        return $this->entry_id;
    }

    public function setEntryId(?string $entry_id): Audit
    {
        $this->entry_id = $entry_id;

        return $this;
    }

    public function getTermHandle(): ?string
    {
        return $this->term_handle;
    }

    public function setTermHandle(?string $term_handle): Audit
    {
        $this->term_handle = $term_handle;

        return $this;
    }

    public function getAssetId(): ?string
    {
        return $this->asset_id;
    }

    public function setAssetId(?string $asset_id): Audit
    {
        $this->asset_id = $asset_id;

        return $this;
    }

    public function getGlobalSet(): ?string
    {
        return $this->global_set;
    }

    public function setGlobalSet(?string $global_set): Audit
    {
        $this->global_set = $global_set;

        return $this;
    }

    public function toArray()
    {
        return [
            'message' => $this->getMessage(),
            'properties' => $this->getProperties(),
            'collection' => $this->getCollection(),
            'taxonomy' => $this->getTaxonomy(),
            'global' => $this->getGlobal(),
            'navigation' => $this->getNavigation(),
            'asset_container' => $this->getAssetContainer(),
            'tree' => $this->getTree(),
            'roles' => $this->getRoles(),
            'groups' => $this->getGroups(),
            'entry_id' => $this->getEntryId(),
            'term_handle' => $this->getTermHandle(),
            'asset_id' => $this->getAssetId(),
            'global_set' => $this->getGlobalSet(),
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
