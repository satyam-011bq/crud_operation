<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'status', 'image_path'];

    // Task ke images ko retrieve karne ke liye
    public function images()
    {
        return $this->hasMany(Image::class);
    }

}
