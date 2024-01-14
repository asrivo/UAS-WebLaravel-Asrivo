<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;

class Article extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];

    //Relasi tabel artikel dan tabel user / One to One (1 Artikel mempunyai 1 user)
    public function user(){
        return $this->belongsTo(User::class);
    }

    //Relasi tabel artikel dan tabel category / One to One (1 Artikel mempunyai 1 category)
    public function category(){
        return $this->belongsTo(Category::class);
    }

    //Relasi tabel artikel dan tabel Tag / Many to Many (1 Artikel mempunyai banyak tag, dan 1 tag bisa mempunyai banyak artikel)
    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'judul'
            ]
        ];
    }
}
