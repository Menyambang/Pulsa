<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

class UserM extends Model
{
  protected $table = 'm_user';
  protected $touches = ['alamat'];

  protected $maps = [
    'userEmail' => 'email',
  ];

  protected $append = ['email'];

  public function alamat()
  {
    return $this->hasMany(AlamatM::class, 'usralUsrEmail', 'email');
  }
}
