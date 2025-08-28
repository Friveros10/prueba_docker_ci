<?php
namespace App\Controllers;

use App\Models\TaskModel;
use CodeIgniter\Controller;

class TaskApiController extends Controller
{

    public function getTasks()
    {
        $taskModel = new \App\Models\TaskModel();
        $tasks     = $taskModel->findAll();

        return $this->response->setJSON($tasks);
    }

    public function storeTasks()
    {
        $taskModel = new \App\Models\TaskModel();

        $completedRaw = $this->request->getPost('completed');

        $completed = (! empty($completedRaw) && $completedRaw == '1') ? 1 : 0;

        $taskModel->save([
            'title'      => $this->request->getPost('title'),
            'completed'  => $completed,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return $this->response->setJSON(['message' => 'Tarea agregada correctamente.'])->setStatusCode(201);
    }

    public function delete($id)
    {
        $taskModel = new \App\Models\TaskModel();

        if (! $taskModel->find($id)) {
            return $this->response->setStatusCode(404)->setJSON(['message' => 'Tarea no encontrada']);
        }

        $taskModel->delete($id);

        return $this->response->setJSON(['message' => 'Tarea eliminada correctamente']);
    }

    public function showTasks($id)
    {
        $model = new \App\Models\TaskModel();
        $task  = $model->find($id);

        if (! $task) {
            return $this->failNotFound('Tarea no encontrada.');
        }

        return $this->response->setJSON($task);

    }
}
