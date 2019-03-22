<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
	protected $guarded = ['id'];

	protected $dates = ['published_at'];

	function scopePage($query)
	{
		return $query->where('blog_post', 0);
	}

	function scopePost($query)
	{
		return $query->where('blog_post', 1)->orderBy('published_at', 'desc');
	}

	function scopePublished($query)
	{
		return $query->where('published', 1);
	}

	function getSlugAttribute()
	{
		return ($this->attributes['blog_post'] ? 'blog/' : '') . $this->attributes['slug'];
	}
}
