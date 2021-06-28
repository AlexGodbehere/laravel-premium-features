<?php
declare(strict_types=1);

namespace AlexGodbehere\LaravelPremiumFeatures\Model;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Config;

/**
 * Model for the table that will store the details for a Feature.
 */
class Feature extends Model
{
    protected $guarded = [];

    /**
     * @var string
     */
    protected $table = 'features';

    /**
     * Returns the class that defines this feature.
     *
     * @return object
     */
    public function getClass(): object
    {
        return new $this->class_name();
    }
}