<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ExpenseMaterial extends Pivot
{
	protected $hidden = ['expense_id', 'material_id'];
    // protected $visible = ['price'];
}
