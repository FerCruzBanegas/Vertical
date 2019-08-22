<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Box extends ApiModel
{
    use SoftDeletes, LogsActivity, FullTextSearch;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'date_init', 'date_end', 'note', 'user_id',
    ];

    protected $searchable = [
        'title',
    ];

    public function accounts()
    {
        return $this->belongsToMany(Account::class)->withPivot('income', 'expense', 'cash')->withTimestamps();
    }
}
// SELECT
//     t1.title,
//     COALESCE(t2.amount, 0) AS expenses,
//     COALESCE(t3.amount, 0) AS incomes
// FROM accounts t1
// LEFT JOIN
// (
//     SELECT account_id, SUM(amount) AS amount
//     FROM expenses
//     WHERE created_at >= '2019-06-13 20:11:46' AND created_at <= '2019-08-21 21:11:46'
//     GROUP BY account_id
// ) t2
//     ON t1.id = t2.account_id
// LEFT JOIN
// (
//     SELECT account_id, SUM(amount) AS amount
//     FROM incomes
//     WHERE created_at >= '2019-06-11 21:07:57' AND created_at <= '2019-08-21 21:11:46'
//     GROUP BY account_id
// ) t3
//     ON t1.id = t3.account_id
// ORDER BY
//     t1.title;