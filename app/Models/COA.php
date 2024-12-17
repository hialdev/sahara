<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use function PHPSTORM_META\map;

class COA extends Model
{
    use HasFactory;
    protected $connection = 'osano';
    protected $table = 'chart_of_accounts';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        // Secara otomatis mengatur UUID saat membuat model
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });

        static::deleting(function ($model) {
            foreach ($model->entries as $entry){
                $entry->delete();
            }
            foreach ($model->childs() as $child){
                $child->delete();
            }
        });
    }

    protected $keyType = 'string';
    public $incrementing = false;

    public function parent(){
        $no_parent = explode('.',$this->no_code);
        $no_parent = $no_parent[0].'.'.$no_parent[1];
        $coa = self::where('no_code', $no_parent)->first();
        return $coa;
    }

    public function childs()
    {
        $prefix = $this->no_code;

        return self::where('no_code', 'like', $prefix . '.%')
                    ->orderBy('no_code', 'asc')->get();
    }

    public function accountType(){
        return $this->belongsTo(AccountType::class, 'account_type', 'id');
    }

    public function entries(){
        return $this->hasMany(JurnalEntry::class, 'chart_of_account_id');
    }
}
