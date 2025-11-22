<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_active',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Relationship: One academic year has many agendas
     */
    public function agendas()
    {
        return $this->hasMany(Agenda::class);
    }

    /**
     * Scope: Get the active academic year
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the currently active academic year
     */
    public static function getActive()
    {
        return static::where('is_active', true)->first();
    }

    /**
     * Set this academic year as active and deactivate others
     */
    public function setAsActive()
    {
        // Deactivate all other academic years
        static::where('id', '!=', $this->id)->update(['is_active' => false]);
        
        // Activate this one
        $this->update(['is_active' => true]);
    }

    /**
     * Boot method to ensure only one active year
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($tahunAjaran) {
            // If this is being set as active, deactivate others
            if ($tahunAjaran->is_active) {
                static::where('id', '!=', $tahunAjaran->id)
                    ->update(['is_active' => false]);
            }
        });
    }
}
