<?php
namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $table = 'tasks';

    protected $primaryKey = 'id';

    protected $allowedFields = ['title', 'completed', 'created_at'];

    protected $validationRules = [
        'title'     => 'required|min_length[3]|max_length[255]',
        'completed' => 'in_list[0,1]',
    ];

    protected $useTimestamps = false; 
}
