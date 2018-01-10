<?php

namespace Dot\Galleries\Models;

use Dot\Media\Models\Media;
use Dot\Platform\Model;
use Dot\Users\Models\User;

/*
 * Class Gallery
 * @package Dot\Galleries\Models
 */
class Gallery extends Model
{

    /*
     * @var string
     */
    protected $table = 'galleries';

    /*
     * @var string
     */
    protected $primaryKey = 'id';

    /*
     * @var array
     */
    protected $fillable = [
        "name",
        "author"
    ];

    /*
     * @var array
     */
    protected $sluggable = [
        'slug' => 'name'
    ];

    /*
     * @var array
     */
    protected $searchable = [
        "name"
    ];

    /*
     * @var array
     */
    protected $creatingRules = [
        "name" => "required"
    ];

    /*
     * @var array
     */
    protected $updatingRules = [
        "name" => "required"
    ];

    /*
     * user relation
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

    /*
     * files relation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    function files()
    {
        return $this->belongsToMany(Media::class, "galleries_media", "gallery_id", "media_id");
    }
}
