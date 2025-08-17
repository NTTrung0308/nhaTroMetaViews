<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class ServiceAbout extends Model
{
    use HasFactory;
     protected $fillable = [
        'title',
        'description',
        'image',
        'content',
           'show_on_home',
           'slug'
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($serviceAbout) {
            if (empty($serviceAbout->slug) && !empty($serviceAbout->title)) {
                $serviceAbout->slug = Str::slug($serviceAbout->title);

                // Đảm bảo slug là unique
                $originalSlug = $serviceAbout->slug;
                $count = 1;
                while (self::where('slug', $serviceAbout->slug)->exists()) {
                    $serviceAbout->slug = $originalSlug . '-' . $count++;
                }
            }
        });

        static::updating(function ($serviceAbout) {
            if (empty($serviceAbout->slug) && !empty($serviceAbout->title)) {
                $serviceAbout->slug = Str::slug($serviceAbout->title);

                // Đảm bảo slug là unique khi update
                $originalSlug = $serviceAbout->slug;
                $count = 1;
                while (self::where('slug', $serviceAbout->slug)
                    ->where('id', '!=', $serviceAbout->id)
                    ->exists()
                ) {
                    $serviceAbout->slug = $originalSlug . '-' . $count++;
                }
            }
        });
    }
}
