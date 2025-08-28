<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tareas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            padding: 20px;
            margin: 0;
        }

        h1 {
            margin-bottom: 20px;
            color: #333;
        }

        a.create-btn {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 16px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        a.create-btn:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        td.actions a {
            margin-right: 10px;
            text-decoration: none;
            color: #333;
            font-size: 18px;
        }

        td.actions a:hover {
            color: #007bff;
        }

        .icon {
            font-family: Arial, sans-serif;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetch('/api/tasks')
                .then(response => response.json())
                .then(tasks => {
                    const tbody = document.getElementById('tasks-body');
                    tbody.innerHTML = '';

                    tasks.forEach(task => {
                        const tr = document.createElement('tr');

                        tr.innerHTML = `
                            <td>${task.id}</td>
                            <td>${task.title}</td>
                            <td>${task.completed == 1 ? 'Sí' : 'No'}</td>
                            <td class="actions">
                                <a href="/tasks/show/${task.id}" title="Ver">&#128065;</a>
                                <a href="/tasks/edit/${task.id}" title="Editar">&#9998;</a>
                                <a href="/tasks/delete/${task.id}" title="Eliminar">&#128465;</a>
                            </td>
                        `;

                        tbody.appendChild(tr);
                    });
                })
                .catch(error => {
                    console.error('Error al obtener tareas:', error);
                });
        });
    </script>
</head>
<body>
    <h1>Tareas</h1>

    <a href="/tasks/create" class="create-btn">Crear nueva tarea</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Completada</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="tasks-body">

    </tbody>
    </table>
</body>
</html>
