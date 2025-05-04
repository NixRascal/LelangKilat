<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories'; // pastikan sesuai nama tabel di database
    public $timestamps = false; // matikan timestamps jika tabel tidak punya created_at & updated_at
    protected $fillable = ['name', 'icon']; // kolom yang boleh diisi
}
