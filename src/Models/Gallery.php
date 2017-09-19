<?php

namespace Dot\Galleries\Models;

use Dot\Model;
use Dot\Users\Models\User;
use Dot\Media\Models\Media;


class Gallery extends Model {

    protected $module = 'galleries';

    protected $table = 'galleries';

    protected $primaryKey = 'id';

    protected $fillable = [
        "name",
        "author"
    ];

    protected $sluggable = [
        'slug' => 'name'
    ];

    protected $searchable = [
        "name"
    ];

    protected $creatingRules = [
        "name" => "required"
    ];

    protected $updatingRules = [
        "name" => "required"
    ];

    public function user()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

    function files(){
        return $this->belongsToMany(Media::class, "galleries_media", "gallery_id", "media_id");
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        //static::addGlobalScope(new LangScope);
    }

}
