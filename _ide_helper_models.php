<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models\Admin{
/**
 * App\Models\Admin\Page
 *
 * @property int $id
 * @property string $slug
 * @property string $lang
 * @property string|null $title
 * @property string|null $description
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string|null $route
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $alt_langs
 * @property-read mixed $props
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Prop[] $properties
 * @property-read int|null $properties_count
 * @method static \Illuminate\Database\Eloquent\Builder|Page bySlug($slug, $abortIfNull = true)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel exclude($value = [])
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel getOrdered()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel halfYear()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel month()
 * @method static \Illuminate\Database\Eloquent\Builder|Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel paginated($append = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Page query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel setPerPage($perPage)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel week()
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel year()
 */
	class Page extends \Eloquent {}
}

namespace App\Models\Admin{
/**
 * App\Models\Admin\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Propaganistas\LaravelPhone\PhoneNumber|null|null $phone
 * @property string $username
 * @property string $role
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $admin_avatar
 * @property-read mixed $avatar
 * @property-read mixed $first_name
 * @property-read mixed $is_admin
 * @property-read mixed $is_editor
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\App\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel exclude($value = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User filter(array $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel getOrdered()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel halfYear()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel month()
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel paginated($append = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel setPerPage($perPage)
 * @method static \Illuminate\Database\Eloquent\Builder|User updateUser($data)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel week()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel year()
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BaseModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel exclude($value = [])
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel getOrdered()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel halfYear()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel month()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel paginated($append = null)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel setPerPage($perPage)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel week()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel year()
 */
	class BaseModel extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DatabaseStorageModel
 *
 * @property int $id
 * @property string $cart_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DatabaseStorageModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DatabaseStorageModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DatabaseStorageModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|DatabaseStorageModel whereCartData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DatabaseStorageModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DatabaseStorageModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DatabaseStorageModel whereUpdatedAt($value)
 */
	class DatabaseStorageModel extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FAQ
 *
 * @property int $id
 * @property string $lang
 * @property string|null $title
 * @property string|null $description
 * @property int $position
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel exclude($value = [])
 * @method static \Database\Factories\FAQFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel getOrdered()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel halfYear()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel month()
 * @method static \Illuminate\Database\Eloquent\Builder|FAQ newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FAQ newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel paginated($append = null)
 * @method static \Illuminate\Database\Eloquent\Builder|FAQ query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel setPerPage($perPage)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel week()
 * @method static \Illuminate\Database\Eloquent\Builder|FAQ whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FAQ whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FAQ whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FAQ wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FAQ whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel year()
 */
	class FAQ extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Media
 *
 * @property int $id
 * @property string $model_type
 * @property int $model_id
 * @property string|null $uuid
 * @property string $collection_name
 * @property string $name
 * @property string $file_name
 * @property string|null $mime_type
 * @property string $disk
 * @property string|null $conversions_disk
 * @property int $size
 * @property array $manipulations
 * @property array $custom_properties
 * @property array $generated_conversions
 * @property array $responsive_images
 * @property int|null $order_column
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $model
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|static[] all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|static[] get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Media newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|Media query()
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereCollectionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereConversionsDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereCustomProperties($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereGeneratedConversions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereManipulations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereOrderColumn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereResponsiveImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereUuid($value)
 */
	class Media extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Order
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $payment_type
 * @property string|null $payment_id
 * @property mixed|null $payment_data
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $email
 * @property array|null $address
 * @property string|null $comment
 * @property string $delivery
 * @property string $amount
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $discounts
 * @property-read mixed $is_paid
 * @property-read mixed $old_amount
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel exclude($value = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Order filter(array $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel getOrdered()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel halfYear()
 * @method static \Illuminate\Database\Eloquent\Builder|Order isPaid()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel month()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel paginated($append = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel setPerPage($perPage)
 * @method static \Illuminate\Database\Eloquent\Builder|Order sumAndCount()
 * @method static \Illuminate\Database\Eloquent\Builder|Order user($user_id)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel week()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDelivery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel year()
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderItem
 *
 * @property int $id
 * @property int $order_id
 * @property int|null $product_id
 * @property string $name
 * @property string $price
 * @property string $discount_price
 * @property int $quantity
 * @property array|null $variations
 * @property-read mixed $sum_old_price
 * @property-read mixed $sum_price
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel exclude($value = [])
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel getOrdered()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel halfYear()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel month()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel paginated($append = null)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel setPerPage($perPage)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel week()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereDiscountPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereVariations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel year()
 */
	class OrderItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Page
 *
 * @property int $id
 * @property string $slug
 * @property string $lang
 * @property string|null $title
 * @property string|null $description
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string|null $route
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $props
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Prop[] $properties
 * @property-read int|null $properties_count
 * @method static \Illuminate\Database\Eloquent\Builder|Page bySlug($slug, $abortIfNull = true)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel exclude($value = [])
 * @method static \Database\Factories\PageFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel getOrdered()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel halfYear()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel month()
 * @method static \Illuminate\Database\Eloquent\Builder|Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel paginated($append = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Page query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel setPerPage($perPage)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel week()
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel year()
 */
	class Page extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $slug
 * @property string $lang
 * @property bool $is_published
 * @property string $price
 * @property string|null $title
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property int $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read mixed $cart_price
 * @property-read mixed $current_price
 * @property-read mixed $gallery
 * @property-read mixed $is_available
 * @property-read mixed $json
 * @property-read mixed $preview
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\App\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel exclude($value = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Product filter(array $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|Product find4Cart($id)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel getOrdered()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel halfYear()
 * @method static \Illuminate\Database\Eloquent\Builder|Product isPublished()
 * @method static \Illuminate\Database\Eloquent\Builder|Product isStock()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel month()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product orderStock()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel paginated($append = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Product priorityIds($ids = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Product publicCatalog($category = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Product searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Product set4Cart()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel setPerPage($perPage)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel week()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product withPrice($select = null)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel year()
 */
	class Product extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\ProductAttribute
 *
 * @property int $id
 * @property string|null $name
 * @property string $lang
 * @property int $product_attribute_type_id
 * @property int $position
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel exclude($value = [])
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel getOrdered()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel halfYear()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel month()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel paginated($append = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel setPerPage($perPage)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel week()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereProductAttributeTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel year()
 */
	class ProductAttribute extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductAttributeType
 *
 * @property int $id
 * @property string|null $name
 * @property string $lang
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel exclude($value = [])
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel getOrdered()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel halfYear()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel month()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel paginated($append = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeType query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel setPerPage($perPage)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel week()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeType whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel year()
 */
	class ProductAttributeType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductCategory
 *
 * @property int $id
 * @property string $slug
 * @property string $lang
 * @property string $title_ru
 * @property string|null $description_ru
 * @property string|null $meta_title_ru
 * @property string|null $meta_description_ru
 * @property string|null $meta_keywords_ru
 * @property string $title
 * @property string|null $description
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property int $position
 * @property int $_lft
 * @property int $_rgt
 * @property int|null $parent_id
 * @property-read \Kalnoy\Nestedset\Collection|ProductCategory[] $children
 * @property-read int|null $children_count
 * @property-read mixed $type
 * @property-read ProductCategory|null $parent
 * @method static \Kalnoy\Nestedset\Collection|static[] all($columns = ['*'])
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory ancestorsAndSelf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory ancestorsOf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory applyNestedSetScope(?string $table = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory countErrors()
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory d()
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory defaultOrder(string $dir = 'asc')
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory descendantsAndSelf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory descendantsOf($id, array $columns = [], $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|BaseModel exclude($value = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory fixSubtree($root)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory fixTree($root = null)
 * @method static \Kalnoy\Nestedset\Collection|static[] get($columns = ['*'])
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory get4Admin($model)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory getAllCategories($model)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory getNodeData($id, $required = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|BaseModel getOrdered()
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory getPlainNodeData($id, $required = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory getTotalErrors()
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory getTree($model)
 * @method static \Kalnoy\Nestedset\QueryBuilder|BaseModel halfYear()
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory hasChildren()
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory hasParent()
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory isBroken()
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory isUnique()
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory leaves(array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory makeGap(int $cut, int $height)
 * @method static \Kalnoy\Nestedset\QueryBuilder|BaseModel month()
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory moveNode($key, $position)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory newModelQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory newQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory onlyModel($model)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory orWhereAncestorOf(bool $id, bool $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory orWhereDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory orWhereNodeBetween($values)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory orWhereNotDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|BaseModel ordered()
 * @method static \Kalnoy\Nestedset\QueryBuilder|BaseModel paginated($append = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory query()
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory rebuildSubtree($root, array $data, $delete = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory rebuildTree(array $data, $delete = false, $root = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory reversed()
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory root(array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|BaseModel setPerPage($perPage)
 * @method static \Kalnoy\Nestedset\QueryBuilder|BaseModel week()
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory whereAncestorOf($id, $andSelf = false, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory whereAncestorOrSelf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory whereDescendantOf($id, $boolean = 'and', $not = false, $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory whereDescendantOrSelf(string $id, string $boolean = 'and', string $not = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory whereDescription($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory whereDescriptionRu($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory whereId($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory whereIsAfter($id, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory whereIsBefore($id, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory whereIsLeaf()
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory whereIsRoot()
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory whereLang($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory whereLft($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory whereMetaDescription($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory whereMetaDescriptionRu($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory whereMetaKeywords($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory whereMetaKeywordsRu($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory whereMetaTitle($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory whereMetaTitleRu($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory whereNodeBetween($values, $boolean = 'and', $not = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory whereNotDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory whereParentId($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory wherePosition($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory whereRgt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory whereSlug($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory whereTitle($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory whereTitleRu($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory withDepth(string $as = 'depth')
 * @method static \Kalnoy\Nestedset\QueryBuilder|ProductCategory withoutRoot()
 * @method static \Kalnoy\Nestedset\QueryBuilder|BaseModel year()
 */
	class ProductCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductProperty
 *
 * @property int $product_id
 * @property string $title
 * @property string|null $description
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel exclude($value = [])
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel getOrdered()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel halfYear()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel month()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductProperty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductProperty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel paginated($append = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductProperty query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel setPerPage($perPage)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel week()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductProperty whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductProperty whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductProperty whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel year()
 */
	class ProductProperty extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductVariant
 *
 * @property int $id
 * @property int $product_id
 * @property string|null $title
 * @property string|null $price
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel exclude($value = [])
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel getOrdered()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel halfYear()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel month()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel paginated($append = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel setPerPage($perPage)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel week()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel year()
 */
	class ProductVariant extends \Eloquent {}
}

namespace App\Models\Product{
/**
 * App\Models\Product\ProductVariation
 *
 * @property-read mixed $for_cart
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel exclude($value = [])
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel getOrdered()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel halfYear()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel month()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel paginated($append = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel setPerPage($perPage)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel week()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel year()
 */
	class ProductVariation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Prop
 *
 * @property int $id
 * @property string|null $tab
 * @property string|null $model_type
 * @property int|null $model_id
 * @property string $type
 * @property string $key
 * @property string|null $title
 * @property string|null $value_string
 * @property string|null $value_text
 * @property int $position
 * @property-read mixed $admin_file
 * @property-read mixed $admin_files
 * @property-read mixed $admin_value
 * @property-read mixed $file
 * @property-read mixed $file_path
 * @property-read mixed $files
 * @property-read mixed $files_path
 * @property-read mixed $model_name
 * @property-read mixed $value
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\App\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $model
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel exclude($value = [])
 * @method static \Database\Factories\PropFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Prop get4Admin($addValues = true)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel getOrdered()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel halfYear()
 * @method static \Illuminate\Database\Eloquent\Builder|Prop list($model_type = null, $model_id = null)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel month()
 * @method static \Illuminate\Database\Eloquent\Builder|Prop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Prop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel paginated($append = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Prop query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel setPerPage($perPage)
 * @method static \Illuminate\Database\Eloquent\Builder|Prop tabs()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel week()
 * @method static \Illuminate\Database\Eloquent\Builder|Prop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prop whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prop whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prop whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prop wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prop whereTab($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prop whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prop whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prop whereValueString($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prop whereValueText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel year()
 */
	class Prop extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Propaganistas\LaravelPhone\PhoneNumber|null|null $phone
 * @property string $username
 * @property string $role
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $avatar
 * @property-read mixed $first_name
 * @property-read mixed $is_admin
 * @property-read mixed $is_editor
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\App\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel exclude($value = [])
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel getOrdered()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel halfYear()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel month()
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel paginated($append = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel setPerPage($perPage)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel week()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel year()
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\Authenticatable, \Illuminate\Contracts\Auth\Access\Authorizable, \Illuminate\Contracts\Auth\CanResetPassword, \Spatie\MediaLibrary\HasMedia, \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

