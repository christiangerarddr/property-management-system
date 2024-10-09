<?php

namespace App\Models;

use App\Traits\CreatedUpdatedDeletedBy;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
  use CreatedUpdatedDeletedBy;
}
