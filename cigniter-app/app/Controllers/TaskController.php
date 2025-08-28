<?php
namespace App\Controllers;

use App\Models\TaskModel;
use CodeIgniter\Controller;

class TaskController extends Controller
{
    // Muestra todas las tareas
    public function index()
    {
        return view('tasks/index');
    }

    // Muestra el formulario para crear una nueva tarea
    public function create()
    {
        return view('tasks/create');
    }

    public function deleteView($id)
    {
        $taskModel = new \App\Models\TaskModel();
        $task      = $taskModel->find($id);

        if (! $task) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Tarea no encontrada");
        }

        return view('tasks/delete', ['task' => $task]);
    }

    public function show($id)
    {
        return view('tasks/show', ['id' => $id]);
    }

    // Almacena una nueva tarea
    public function store()
    {
        $taskModel = new TaskModel();

        // Validación
        if (! $this->validate([
            'title'     => 'required|min_length[3]|max_length[255]',
            'completed' => 'in_list[0,1]',
        ])) {
            return redirect()->to('/tasks/create')->withInput();
        }

        // Inserta la nueva tarea
        $taskModel->save([
            'title'      => $this->request->getPost('title'),
            'completed'  => $this->request->getPost('completed'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/tasks')->with('success', 'Tarea agregada correctamente.');
    }

    // Muestra el formulario para editar una tarea
    public function edit($id)
    {
        $taskModel    = new TaskModel();
        $data['task'] = $taskModel->find($id);

        return view('tasks/edit', $data);
    }

    // Actualiza una tarea
    public function update($id)
    {
        $taskModel = new TaskModel();

        // Validación
        if (! $this->validate([
            'title'     => 'required|min_length[3]|max_length[255]',
            'completed' => 'in_list[0,1]',
        ])) {
            return redirect()->to('/tasks/edit/' . $id)->withInput();
        }

        // Actualiza la tarea
        $taskModel->update($id, [
            'title'     => $this->request->getPost('title'),
            'completed' => $this->request->getPost('completed'),
        ]);

        return redirect()->to('/tasks')->with('success', 'Tarea actualizada correctamente.');
    }
}
