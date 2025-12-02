<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'template_text',
        'variables',
        'is_default',
        'description',
    ];

    protected $casts = [
        'variables' => 'array',
        'is_default' => 'boolean',
    ];

    public function render(array $data): string
    {
        $text = $this->template_text;
        
        foreach ($data as $key => $value) {
            $text = str_replace("[{$key}]", $value, $text);
        }
        
        return $text;
    }

    public function scopeDefault($query, $category)
    {
        return $query->where('category', $category)
                    ->where('is_default', true)
                    ->first();
    }
}