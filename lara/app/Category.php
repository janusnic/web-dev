<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['title','slug', 'parent_id', 'seo_title', 'seo_key', 'seo_desc'];

  public function setTitleAttribute($value) //Всякий раз, когда объекту присваивается свойство title, будет вызван метод setTitleAttribute
  {                                         //который проверит его на существование и добавит slug
    $this->attributes['title'] = $value;

    if (! $this->exists) {
      $this->attributes['slug'] = str_slug($value);
    }
  }

}
