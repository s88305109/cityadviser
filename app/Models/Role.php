<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'role';
    protected $primaryKey = 'role_id';

    public static function getRoles($type)
    {
        $roles = Role::where('type', $type)
            ->whereNull('parent')
            ->orderBy('sort', 'asc')
            ->get();

        foreach($roles as $key => $row) {
            $childs = Role::where('type', $type)
                ->where('parent', $row->role_id)
                ->orderBy('sort', 'asc')
                ->get();

            if (! empty($childs))
                $roles[$key]['child'] = $childs;

            foreach($childs as $key2 => $row2) {
                $grandson = Role::where('type', $type)
                    ->where('parent', $row2->role_id)
                    ->orderBy('sort', 'asc')
                    ->get();

                if (! empty($grandson))
                    $roles[$key]['child'][$key2]['child'] = $grandson;
            }
        }

        return $roles;
    }

}
