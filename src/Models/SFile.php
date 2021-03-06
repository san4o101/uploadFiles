<?php

namespace san4o101\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string $name
 * @property string $hash
 * @property string $disk
 * @property string $folder
 * @property string $mimeType
 * @property string $extension
 * @property int $size
 * @property string $duration
 */
class SFile extends Model
{
    use HasFactory;

    protected $table;

    protected $fillable = [
        'name', 'hash', 'disk', 'folder', 'mimeType', 'extension', 'size', 'duration',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'hash' => 'string',
        'disk' => 'string',
        'folder' => 'string',
        'mimeType' => 'string',
        'extension' => 'string',
        'size' => 'integer',
        'duration' => 'string',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(config('upload_files.tables.main'));
    }
    
    public function delete()
    {
        try {
            $this->deleteFile();
        } catch (\Exception $exception) {
            return false;
        }
        
        return parent::delete();
    }
    
    public function forceDelete()
    {
        try {
            $this->deleteFile();
        } catch (\Exception $exception) {
            return false;
        }
        
        return parent::forceDelete();
    }
    
    private function deleteFile() 
    {
        $fullPath = "{$this->folder}/{$this->hash}.{$this->extension}";
        Storage::disk($this->disk)->delete($fullPath);
    }
}
