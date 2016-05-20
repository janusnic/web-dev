<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  protected $dates = ['published_at']; // Не забываем, что колонка published_at содержит дату

  public function setTitleAttribute($value) //Всякий раз, когда объекту присваивается свойство title, будет вызван метод setTitleAttribute
  {                                         //который проверит его на существование и добавит slug
    $this->attributes['title'] = $value;

    if (! $this->exists) {
      $this->attributes['slug'] = str_slug($value);
    }
  }
}
