<?php

namespace Cboxdk\StatamicOverseer\Presets;

use Cboxdk\StatamicOverseer\EventHandlers\FailedLoginHandler;
use Cboxdk\StatamicOverseer\EventHandlers\LoginHandler;
use Cboxdk\StatamicOverseer\EventHandlers\LogoutHandler;
use Cboxdk\StatamicOverseer\EventHandlers\PasswordResetHandler;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicAssetContainerCreated;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicAssetContainerDeleted;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicAssetContainerSaved;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicAssetDeleted;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicAssetReplaced;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicAssetReuploaded;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicAssetSaved;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicAssetUploaded;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicCollectionCreated;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicCollectionDeleted;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicCollectionSaved;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicCollectionTreeSaved;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicEntryCreated;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicEntryDeleted;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicEntrySaved;
use Statamic\Events\CollectionCreated;

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
            \Illuminate\Auth\Events\Failed::class => FailedLoginHandler::class,
            \Illuminate\Auth\Events\PasswordReset::class => PasswordResetHandler::class, // not being called from Statamic
            // todo: oauth events
        ];
    }

    public static function statamic()
    {
        return [
            \Statamic\Events\AssetContainerCreated::class => StatamicAssetContainerCreated::class,
            \Statamic\Events\AssetContainerDeleted::class => StatamicAssetContainerDeleted::class,
            \Statamic\Events\AssetContainerSaved::class => StatamicAssetContainerSaved::class,
            \Statamic\Events\AssetDeleted::class => StatamicAssetDeleted::class,
            \Statamic\Events\AssetReplaced::class => StatamicAssetReplaced::class,
            \Statamic\Events\AssetReuploaded::class => StatamicAssetReuploaded::class,
            \Statamic\Events\AssetSaved::class => StatamicAssetSaved::class,
            \Statamic\Events\AssetUploaded::class => StatamicAssetUploaded::class,
            //            \Statamic\Events\BlueprintCreated::class => null,
            //            \Statamic\Events\BlueprintDeleted::class => null,
            //            \Statamic\Events\BlueprintSaved::class => null,
            \Statamic\Events\CollectionCreated::class => StatamicCollectionCreated::class,
            \Statamic\Events\CollectionDeleted::class => StatamicCollectionDeleted::class,
            \Statamic\Events\CollectionSaved::class => StatamicCollectionSaved::class,
            //            \Statamic\Events\CollectionTreeDeleted::class => null,
            \Statamic\Events\CollectionTreeSaved::class => StatamicCollectionTreeSaved::class,
            \Statamic\Events\EntryCreated::class => StatamicEntryCreated::class,
            \Statamic\Events\EntryDeleted::class => StatamicEntryDeleted::class,
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
