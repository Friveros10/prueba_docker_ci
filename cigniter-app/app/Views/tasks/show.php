<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Ver tarea</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            width: 400px;
        }

        h1 {
            margin-top: 0;
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .detail {
            margin-bottom: 15px;
        }

        .detail label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        .detail span {
            display: block;
            font-size: 16px;
            color: #222;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .error {
            color: #c0392b;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Detalle de tarea</h1>

        <div class="detail">
            <label>ID:</label>
            <span id="task-id">Cargando...</span>
        </div>

        <div class="detail">
            <label>Título:</label>
            <span id="task-title">Cargando...</span>
        </div>

        <div class="detail">
            <label>Completada:</label>
            <span id="task-completed">Cargando...</span>
        </div>

        <a href="/tasks" class="back-link">← Volver al listado</a>

        <div class="error" id="error-message"></div>
    </div>

    <script>
        const taskId = <?php echo json_encode($id)?>;

        fetch(`/api/tasks/show/${taskId}`)
            .then(async response => {
                const contentType = response.headers.get('content-type');
                const isJson = contentType && contentType.includes('application/json');
                const data = isJson ? await response.json() : null;

                if (!response.ok) {
                    const errorMsg = data?.message || data?.error || `Error ${response.status}`;
                    throw new Error(errorMsg);
                }

                return data;
            })
            .then(task => {
                document.getElementById('task-id').textContent = task.id;
                document.getElementById('task-title').textContent = task.title;
                document.getElementById('task-completed').textContent = task.completed == 1 ? 'Sí' : 'No';
            })
            .catch(error => {
                document.getElementById('error-message').textContent = error.message;
                document.getElementById('task-id').textContent = '-';
                document.getElementById('task-title').textContent = '-';
                document.getElementById('task-completed').textContent = '-';
            });
    </script>
</body>
</html>
