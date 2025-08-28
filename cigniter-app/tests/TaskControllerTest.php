<?php
namespace App\Tests;

use App\Models\TaskModel;
use CodeIgniter\Test\CIUnitTestCase;

class TaskControllerTest extends CIUnitTestCase
{
    protected $taskModel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->taskModel = new TaskModel();
    }

    public function testCreateTask()
    {
        $data = [
            'title'     => 'Tarea creada en test ' . time(),
            'completed' => 0,
        ];

        $insertedId = $this->taskModel->insert($data);

        $this->assertIsInt($insertedId, 'El ID insertado debe ser un entero');

        $task = $this->taskModel->find($insertedId);

        $this->assertNotNull($task, 'La tarea debe existir en la base de datos');
        $this->assertEquals($data['title'], $task['title']);
        $this->assertEquals($data['completed'], $task['completed']);
    }

    public function testDeleteFirstTask()
    {
        // Obtener el primer registro (por id ascendente)
        $firstTask = $this->taskModel->orderBy('id', 'ASC')->first();

        if (! $firstTask) {
            $this->markTestSkipped('No hay tareas para eliminar.');
            return;
        }

        $taskId = $firstTask['id'];

        // Eliminar la tarea
        $this->taskModel->delete($taskId);

        // Verificar que la tarea fue eliminada
        $deletedTask = $this->taskModel->find($taskId);
        $this->assertNull($deletedTask, 'La tarea debe haber sido eliminada');
    }

    public function testUpdateTask()
    {
        // Intentamos obtener el último registro
        $lastTask = $this->taskModel->orderBy('id', 'DESC')->first();

        if ($lastTask) {
            $taskId = $lastTask['id'];
        } else {
            // Si no hay registros, creamos uno nuevo
            $taskId = $this->taskModel->insert([
                'title'     => 'Tarea para actualizar (creada por test)',
                'completed' => 0,
            ]);
            $this->assertIsInt($taskId);
        }

        // Datos para actualizar
        $updatedData = [
            'title'     => 'Tarea actualizada en test',
            'completed' => 1,
        ];

        // Actualizamos el registro
        $this->taskModel->update($taskId, $updatedData);

        // Recuperamos la tarea actualizada
        $task = $this->taskModel->find($taskId);

        $this->assertEquals($updatedData['title'], $task['title']);
        $this->assertEquals($updatedData['completed'], $task['completed']);
    }

}
