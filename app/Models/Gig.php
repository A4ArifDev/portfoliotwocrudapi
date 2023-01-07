<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gig extends Model
{
    use HasFactory;
    protected $fillable = ['gig_title','gig_image_one','gig_image_two','gig_image_three','gig_star','gig_rating','delivery_time','price'];
}
