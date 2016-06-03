<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    public function articles()
    {
        return $this->belongsToMany('App\Article','article_tag');
    }

    public function setNameAttribute($value) 

    {                                        
     $this->attributes['name'] = $value;

     if (! $this->exists) {
       $this->attributes['slug'] = str_slug($value);
     }
   }

    public function getTagListAttribute() { 
    
        return $this->tags->lists('id')->all(); 
    
    }

    public function scopeFindBySlug($query, $slug)
    {
        return $query->whereSlug($slug)->firstOrFail();
    }

    public static function addNeededTags(array $tags)
  {
    if (count($tags) === 0) {
      return;
    }

    $found = static::whereIn('name', $tags)->lists('name')->all();

    foreach (array_diff($tags, $found) as $tag) {
      static::create([
     
        'name' => $tag,
        
      ]);
    }
  }
}
