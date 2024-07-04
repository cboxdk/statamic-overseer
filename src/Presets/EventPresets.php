<?php

namespace Cboxdk\StatamicOverseer\Presets;

use Cboxdk\StatamicOverseer\EventHandlers\LoginHandler;
use Cboxdk\StatamicOverseer\EventHandlers\LogoutHandler;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicCollectionTreeSaved;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicEntrySaved;

class EventPresets
{
    public static function all()
    {
        return [
            ...static::authentication(),
            ...static::statamic(),
        ];
    }

    public static function authentication()
    {
        return [
                        \Illuminate\Auth\Events\Login::class => LoginHandler::class,
                        \Illuminate\Auth\Events\Logout::class => LogoutHandler::class,
            //            \Illuminate\Auth\Events\Failed::class => null,
            //            \Illuminate\Auth\Events\PasswordReset::class => null,
        ];
    }

    public static function statamic()
    {
        return [
            //            \Statamic\Events\AssetContainerCreated::class => null,
            //            \Statamic\Events\AssetContainerDeleted::class => null,
            //            \Statamic\Events\AssetContainerSaved::class => null,
            //            \Statamic\Events\AssetDeleted::class => null,
            //            \Statamic\Events\AssetReplaced::class => null,
            //            \Statamic\Events\AssetReuploaded::class => null,
            //            \Statamic\Events\AssetSaved::class => null,
            //            \Statamic\Events\AssetUploaded::class => null,
            //            \Statamic\Events\BlueprintCreated::class => null,
            //            \Statamic\Events\BlueprintDeleted::class => null,
            //            \Statamic\Events\BlueprintSaved::class => null,
            //            \Statamic\Events\CollectionCreated::class => null,
            //            \Statamic\Events\CollectionDeleted::class => null,
            //            \Statamic\Events\CollectionSaved::class => null,
            //            \Statamic\Events\CollectionTreeDeleted::class => null,
            \Statamic\Events\CollectionTreeSaved::class => StatamicCollectionTreeSaved::class,
            //            \Statamic\Events\EntryCreated::class => null,
            //            \Statamic\Events\EntryDeleted::class => null,
            \Statamic\Events\EntrySaved::class => StatamicEntrySaved::class,
            //            \Statamic\Events\FieldsetCreated::class => null,
            //            \Statamic\Events\FieldsetDeleted::class => null,
            //            \Statamic\Events\FieldsetSaved::class => null,
            //            \Statamic\Events\FormCreated::class => null,
            //            \Statamic\Events\FormDeleted::class => null,
            //            \Statamic\Events\FormSaved::class => null,
            //            \Statamic\Events\FormSubmitted::class => null,
            //            \Statamic\Events\GlobalSetCreated::class => null,
            //            \Statamic\Events\GlobalSetDeleted::class => null,
            //            \Statamic\Events\GlobalSetSaved::class => null,
            //            \Statamic\Events\NavDeleted::class => null,
            //            \Statamic\Events\NavSaved::class => null,
            //            \Statamic\Events\NavTreeDeleted::class => null,
            //            \Statamic\Events\NavTreeSaved::class => null,
            //            \Statamic\Events\RoleDeleted::class => null,
            //            \Statamic\Events\RoleSaved::class => null,
            //            \Statamic\Events\TaxonomyCreated::class => null,
            //            \Statamic\Events\TaxonomyDeleted::class => null,
            //            \Statamic\Events\TaxonomySaved::class => null,
            //            \Statamic\Events\TermCreated::class => null,
            //            \Statamic\Events\TermDeleted::class => null,
            //            \Statamic\Events\TermSaved::class => null,
            //            \Statamic\Events\UserCreated::class => null,
            //            \Statamic\Events\UserDeleted::class => null,
            //            \Statamic\Events\UserSaved::class => null,
            //            \Statamic\Events\UserGroupDeleted::class => null,
            //            \Statamic\Events\UserGroupSaved::class => null,
        ];
    }
}
