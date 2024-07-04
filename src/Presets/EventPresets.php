<?php

namespace Cboxdk\StatamicOverseer\Presets;

use Cboxdk\StatamicOverseer\EventHandlers\FailedLoginHandler;
use Cboxdk\StatamicOverseer\EventHandlers\GenericHandler;
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
use Cboxdk\StatamicOverseer\EventHandlers\StatamicBlueprintCreated;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicBlueprintDeleted;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicBlueprintSaved;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicCollectionCreated;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicCollectionDeleted;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicCollectionSaved;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicCollectionTreeDeleted;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicCollectionTreeSaved;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicEntryCreated;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicEntryDeleted;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicEntrySaved;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicUserCreated;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicUserDeleted;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicUserGroupDeleted;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicUserGroupSaved;
use Cboxdk\StatamicOverseer\EventHandlers\StatamicUserSaved;

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
            \Statamic\Events\BlueprintCreated::class => StatamicBlueprintCreated::class,
            \Statamic\Events\BlueprintDeleted::class => StatamicBlueprintDeleted::class,
            \Statamic\Events\BlueprintSaved::class => StatamicBlueprintSaved::class,
            \Statamic\Events\CollectionCreated::class => StatamicCollectionCreated::class,
            \Statamic\Events\CollectionDeleted::class => StatamicCollectionDeleted::class,
            \Statamic\Events\CollectionSaved::class => StatamicCollectionSaved::class,
            \Statamic\Events\CollectionTreeDeleted::class => StatamicCollectionTreeDeleted::class,
            \Statamic\Events\CollectionTreeSaved::class => StatamicCollectionTreeSaved::class,
            \Statamic\Events\EntryCreated::class => StatamicEntryCreated::class,
            \Statamic\Events\EntryDeleted::class => StatamicEntryDeleted::class,
            \Statamic\Events\EntrySaved::class => StatamicEntrySaved::class,
            \Statamic\Events\FieldsetCreated::class => GenericHandler::class,
            \Statamic\Events\FieldsetDeleted::class => GenericHandler::class,
            \Statamic\Events\FieldsetSaved::class => GenericHandler::class,
            \Statamic\Events\FormCreated::class => GenericHandler::class,
            \Statamic\Events\FormDeleted::class => GenericHandler::class,
            \Statamic\Events\FormSaved::class => GenericHandler::class,
            \Statamic\Events\FormSubmitted::class => GenericHandler::class,
            \Statamic\Events\GlobalSetCreated::class => GenericHandler::class,
            \Statamic\Events\GlobalSetDeleted::class => GenericHandler::class,
            \Statamic\Events\GlobalSetSaved::class => GenericHandler::class,
            \Statamic\Events\NavDeleted::class => GenericHandler::class,
            \Statamic\Events\NavSaved::class => GenericHandler::class,
            \Statamic\Events\NavTreeDeleted::class => GenericHandler::class,
            \Statamic\Events\NavTreeSaved::class => GenericHandler::class,
            \Statamic\Events\RoleDeleted::class => GenericHandler::class,
            \Statamic\Events\RoleSaved::class => GenericHandler::class,
            \Statamic\Events\TaxonomyCreated::class => GenericHandler::class,
            \Statamic\Events\TaxonomyDeleted::class => GenericHandler::class,
            \Statamic\Events\TaxonomySaved::class => GenericHandler::class,
            \Statamic\Events\TermCreated::class => GenericHandler::class,
            \Statamic\Events\TermDeleted::class => GenericHandler::class,
            \Statamic\Events\TermSaved::class => GenericHandler::class,
            \Statamic\Events\UserCreated::class => StatamicUserCreated::class,
            \Statamic\Events\UserDeleted::class => StatamicUserDeleted::class,
            \Statamic\Events\UserSaved::class => StatamicUserSaved::class,
            \Statamic\Events\UserGroupDeleted::class => StatamicUserGroupDeleted::class,
            \Statamic\Events\UserGroupSaved::class => StatamicUserGroupSaved::class,
        ];
    }
}
