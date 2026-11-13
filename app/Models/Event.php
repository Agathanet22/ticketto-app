<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'poster',
        'date',
        'location',
        'description', // Pastikan ini ada
        'min_price',   // Pastikan ini ada
        'long_description', // Ini dari kode Anda, kita pertahankan
        'time',             // Ini dari kode Anda, kita pertahankan
        'banner',           // Ini dari kode Anda, kita pertahankan
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'time' => 'datetime',
    ];

    /**
     * Get the route key name for model binding.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Define the relationship with TicketType model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ticketTypes(): HasMany
    {
        return $this->hasMany(TicketType::class);
    }

    /**
     * Generate a unique slug for the event.
     *
     * @param string $name
     * @return string
     */
    public static function generateSlug(string $name): string
    {
        // Menambahkan timestamp untuk memastikan slug selalu unik
        return Str::slug($name . '-' . time());
    }

    /**
     * Set the event's name and automatically generate a slug.
     *
     * @param string $value
     * @return void
     */
    public function setNameAttribute(string $value): void
    {
        // Fungsi ini tidak kita gunakan lagi karena slug di-handle di controller
        // untuk memastikan keunikan dengan timestamp.
        // Namun, membiarkannya di sini tidak masalah.
        $this->attributes['name'] = $value;
    }

}
