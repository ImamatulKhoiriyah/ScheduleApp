<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;



class Schedule extends Model
{    use Searchable;

    protected $fillable = [
         'title', 'description', 'start_time', 'end_time', 'user_id', 'location',
    ];
    protected $dates = [
        'start_time',
        'end_time',
    ];
    public function searchableAs()
    {
        return 'schedules_index';
    }
    public function toSearchableArray()
    {
        $array = 
        [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'location' => $this->location,
           
            'balancer' =>  $this->balancer
        ];

        // Customize the searchable array if needed
        return $array;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
