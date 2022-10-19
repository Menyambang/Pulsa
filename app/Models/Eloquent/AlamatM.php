<?php 

namespace App\Models\Eloquent;
use Illuminate\Database\Eloquent\Model;

class AlamatM extends Model
{
    protected $table = 'm_user_alamat';
    protected $primaryKey = 'usralId';

    public function users() {
        return $this->belongsTo(UserM::class, 'usralUsrEmail');
    }

}