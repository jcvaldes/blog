<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];
    // para que sea una instancia de carbon para el manejo de fechas
    protected $dates = ['published_at'];

    public function getRouteKeyName() {
        return 'url';
    }

    public function category() {
        // Relacion uno a muchos (inversa)
        return $this->belongsTo(Category::class);
    }

    public function tags() {
        // Relacion muchos a muchos
        return $this->belongsToMany(Tag::class);
    }

    public function photos(){
        // Relacion uno a muchos
        return $this->hasMany(Photo::class);
    }
    
    public function scopePublished($query) {
        $query->whereNotNull('published_at')
            ->where('published_at', '<=', Carbon::now())
            ->latest('published_at');
    }
}
