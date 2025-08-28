<?php
namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'tasks';

    // Clave primaria
    protected $primaryKey = 'id';

    // Campos que se pueden insertar o actualizar
    protected $allowedFields = ['title', 'completed', 'created_at'];

    // Habilitar la validación
    protected $validationRules = [
        'title'     => 'required|min_length[3]|max_length[255]',
        'completed' => 'in_list[0,1]',
    ];

                                      // Configurar el tipo de datos
    protected $useTimestamps = false; // Si no usas las fechas de actualización automáticamente
}
