<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar tarea</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            padding: 20px;
        }

        h1 {
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            max-width: 400px;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="checkbox"] {
            margin-left: 5px;
            transform: scale(1.2);
            vertical-align: middle;
        }

        button {
            margin-top: 20px;
            padding: 10px 16px;
            background-color: #007bff;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .message {
            margin-top: 15px;
            padding: 10px;
            border-radius: 4px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }

        ul {
            padding-left: 20px;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <h1>Editar tarea</h1>

    <form id="edit-task-form" data-task-id="<?= $task['id'] ?>">
        <label for="title">Título:</label>
        <input type="text" name="title" id="title" value="<?= htmlspecialchars(old('title', $task['title'])) ?>" required>

        <label>
            <input type="checkbox" name="completed" id="completed" value="1" <?= old('completed', $task['completed']) ? 'checked' : '' ?>>
            Completada
        </label>

        <button type="submit">Actualizar</button>
    </form>

    <div id="form-messages"></div>

    <a href="/tasks">Volver</a>

    <script>
        const form = document.getElementById('edit-task-form');
        const messages = document.getElementById('form-messages');

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const taskId = form.getAttribute('data-task-id');
            const formData = new FormData(form);

            if (!formData.has('completed')) {
                formData.append('completed', 0);
            }

            fetch('/tasks/update/' + taskId, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(async response => {
                const contentType = response.headers.get("content-type");
                const isJSON = contentType && contentType.includes("application/json");

                if (!response.ok) {
                    const errorData = isJSON ? await response.json() : await response.text();
                    throw errorData;
                }

                return isJSON ? response.json() : {};
            })
            .then(data => {
                messages.innerHTML = `<div class="message success">Tarea actualizada correctamente.</div>`;
            })
            .catch(error => {
                if (typeof error === 'object' && error.errors) {
                    let errorsHtml = '<div class="message error"><ul>';
                    Object.values(error.errors).forEach(err => {
                        errorsHtml += `<li>${err}</li>`;
                    });
                    errorsHtml += '</ul></div>';
                    messages.innerHTML = errorsHtml;
                } else {
                    messages.innerHTML = `<div class="message error">Ocurrió un error al actualizar la tarea.</div>`;
                    console.error(error);
                }
            });
        });
    </script>
</body>
</html>
