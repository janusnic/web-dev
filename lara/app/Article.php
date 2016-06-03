<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Article extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $appends = ['tag_list', 'content_html'];

    protected $fillable = ['title', 'summary', 'content', 'category_id', 'seo_title', 'seo_key', 'seo_desc', 'published_at','seen','active'];
    

     public function tags()
     {
         return $this->belongsToMany('App\Tag','article_tag');
     }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function getTagListAttribute()
    {
        return $this->tags->lists('id');
    }

    public function getContentHtmlAttribute()
    {
        $Parsedown = new \Parsedown();

        return $Parsedown->text($this->content);
    }

    public function setPublishedAtAttribute($date)
    {
        if (is_string($date)) {
            $this->attributes['published_at'] = Carbon::createFromFormat('Y-m-d', $date);
        } else {
            $this->attributes['published_at'] = $date;
        }
    }

     public function setTitleAttribute($value) //Всякий раз, когда объекту присваивается свойство title, будет вызван метод setTitleAttribute
    {                                         //который проверит его на существование и добавит slug
    $this->attributes['title'] = $value;

    if (! $this->exists) {
      $this->attributes['slug'] = str_slug($value);
        }
    }


    public function scopeFindBySlug($query, $slug)
    {
        return $query->whereSlug($slug)->firstOrFail();
    }

    public function syncTags(array $tags)
    {
      Tag::addNeededTags($tags);

      if (count($tags)) {
        $this->tags()->sync(
          Tag::whereIn('name', $tags)->lists('id')->all()
        );
        return;
      }

      $this->tags()->detach();
    }

 
}
