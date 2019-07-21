<?php

namespace netdjw\LoremIpsum\Models;

use Illuminate\Database\Eloquent\Model;

class LoremIpsum extends Model
{
    protected $guarded = [
        'lang',
        'word'
    ];

    protected $table = 'lorem_ipsum';


}
