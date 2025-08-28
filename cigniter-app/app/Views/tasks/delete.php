<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Eliminar tarea</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            padding: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: white;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
            color: #c0392b;
        }

        p {
            margin-bottom: 30px;
            font-size: 1.1em;
        }

        .buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        button {
            padding: 10px 18px;
            font-size: 1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-cancel {
            background-color: #7f8c8d;
            color: white;
        }

        .btn-cancel:hover {
            background-color: #636e72;
        }

        .btn-delete {
            background-color: #e74c3c;
            color: white;
        }

        .btn-delete:hover {
            background-color: #c0392b;
        }

        .message {
            margin-top: 20px;
            font-weight: bold;
        }

        .message.success {
            color: #27ae60;
        }

        .message.error {
            color: #e74c3c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Eliminar tarea</h1>
        <p>¿Estás seguro que deseas eliminar la tarea: <strong><?= esc($task['title']) ?></strong>?</p>

        <div class="buttons">
            <button class="btn-cancel" id="btn-cancel">Cancelar</button>
            <button class="btn-delete" id="btn-delete">Eliminar</button>
        </div>

        <div id="message" class="message"></div>
    </div>

    <script>
        const btnDelete = document.getElementById('btn-delete');
        const btnCancel = document.getElementById('btn-cancel');
        const messageDiv = document.getElementById('message');

        const taskId = <?= esc($task['id']) ?>;

        btnCancel.addEventListener('click', () => {
            window.location.href = '/tasks';
        });

        btnDelete.addEventListener('click', () => {
            messageDiv.textContent = '';
            btnDelete.disabled = true;
            btnCancel.disabled = true;

            fetch(`/api/tasks/delete/${taskId}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(async response => {
                btnDelete.disabled = false;
                btnCancel.disabled = false;

                if (!response.ok) {
                    const err = await response.json();
                    throw new Error(err.message || 'Error al eliminar');
                }

                return response.json();
            })
            .then(data => {
                messageDiv.textContent = data.message;
                messageDiv.className = 'message success';

                setTimeout(() => {
                    window.location.href = '/tasks';
                }, 1500);
            })
            .catch(err => {
                messageDiv.textContent = err.message;
                messageDiv.className = 'message error';
            });
        });
    </script>
</body>
</html>
