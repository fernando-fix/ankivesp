<?php

namespace App\Models;

use App\Helpers\LogAndFlash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Att extends Model
{
    use HasFactory;
    protected $table = 'atts';

    protected $fillable = [
        'name',
        'extension',
        'type',
        'size',
        'folder',
        'file_path',
        'table_name',
        'table_id',
        'field_name',
        'created_by',
        'updated_by',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->created_by = Auth::user()->id;
        });

        self::updating(function ($model) {
            $model->updated_by = Auth::user()->id;
        });
    }

    public function table()
    {
        return $this->morphTo(null, 'table_name', 'table_id');
    }

    public static function attachFile($file, $folder, $table_name, $table_id, $field_name = 'file',  $allowedExtensions = null)
    {
        if (!$file || !$file->isValid()) {
            LogAndFlash::error('Arquivo inválido!');
            return false;
        }

        if (!is_null($allowedExtensions) && !in_array($file->extension(), $allowedExtensions)) {
            LogAndFlash::error('Extensão inválida!');
            return false;
        }

        // Se for um update
        $att = Att::where('table_name', $table_name)->where('table_id', $table_id)->first();
        if ($att) {
            // verificar se arquivo existe
            if (Storage::exists($att->file_path)) {
                Storage::delete($att->file_path);
            }
            $att->delete();
        }

        if (!Storage::exists($folder)) {
            Storage::makeDirectory($folder);
        }

        $data['name'] = time() . '.' . $file->extension();
        $data['extension'] = $file->extension();
        $data['size'] = $file->getSize();
        $data['type'] = $file->getMimeType();
        $data['table_name'] = $table_name;
        $data['table_id'] = $table_id;
        $data['field_name'] = $field_name;
        $data['folder'] = $folder;
        $data['file_path'] = $folder . '/' . $data['name'];
        $data['created_by'] = Auth::user()->id;

        try {
            $att = Att::create($data);
        } catch (\Exception $e) {
            LogAndFlash::error('Erro ao salvar o arquivo', $e->getMessage());
            return false;
        }

        try {
            $file->storeAs($folder, $att->name);
        } catch (\Exception $e) {
            LogAndFlash::error('Erro ao salvar o arquivo', $e->getMessage());
            return false;
        }

        return $att;
    }

    public static function deleteFile($table, $table_id, $field_name)
    {
        $att = Att::where('table_name', $table)->where('table_id', $table_id)->where('field_name', $field_name)->first();
        if ($att) {
            try {
                Storage::delete($att->file_path);
            } catch (\Exception $e) {
                return false;
            }
            try {
                $att->delete();
            } catch (\Exception $e) {
                return false;
            }
        } else {
            return false;
        }
        return true;
    }
}
