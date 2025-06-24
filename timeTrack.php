<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskFlow | Gerenciador de Tarefas</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --secondary: #8b5cf6;
            --accent: #a78bfa;
            --light: #f8fafc;
            --dark: #1e293b;
            --darker: #0f172a;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --gray: #94a3b8;
            --gray-light: #e2e8f0;
            --card-bg: rgba(255, 255, 255, 0.9);
            --card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
            --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            color: var(--dark);
            line-height: 1.5;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 15px;
        }

        h1 {
            text-align: center;
            margin: 25px 0;
            color: var(--darker);
            font-weight: 700;
            font-size: 2.2rem;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .task-form {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            padding: 25px;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--darker);
            font-size: 0.95rem;
        }

        input[type="text"] {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid var(--gray-light);
            border-radius: 12px;
            font-size: 1rem;
            transition: var(--transition);
            background-color: white;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        input[type="text"]:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 20px;
            border: none;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            margin-right: 10px;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .btn i {
            margin-right: 8px;
            font-size: 0.9rem;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn-success {
            background-color: var(--success);
            color: white;
        }

        .btn-success:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn-warning {
            background-color: var(--warning);
            color: white;
        }

        .btn-warning:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn-danger {
            background-color: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn-sm {
            padding: 8px 14px;
            font-size: 0.85rem;
            border-radius: 10px;
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--gray-light);
            color: var(--dark);
        }

        .btn-outline:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .task-list {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            padding: 25px;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--darker);
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 10px;
            color: var(--primary);
        }

        .task-item {
            padding: 18px;
            border-bottom: 1px solid var(--gray-light);
            display: flex;
            flex-direction: column;
            gap: 12px;
            transition: var(--transition);
            border-radius: 12px;
            margin-bottom: 10px;
        }

        .task-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .task-item:hover {
            background-color: rgba(241, 245, 249, 0.6);
        }

        .task-info {
            flex: 1;
        }

        .task-title {
            font-weight: 600;
            margin-bottom: 6px;
            color: var(--darker);
            font-size: 1.05rem;
        }

        .task-time {
            font-size: 0.85rem;
            color: var(--gray);
            display: flex;
            align-items: center;
        }

        .task-time i {
            margin-right: 6px;
            font-size: 0.8rem;
        }

        .task-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .task-active {
            background-color: rgba(99, 102, 241, 0.08);
            border-left: 4px solid var(--primary);
        }

        .completed-tasks {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            padding: 25px;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .completed-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .clear-btn {
            background: none;
            border: none;
            color: var(--danger);
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            transition: var(--transition);
            padding: 6px 10px;
            border-radius: 8px;
        }

        .clear-btn:hover {
            background-color: rgba(239, 68, 68, 0.1);
        }

        .clear-btn i {
            margin-right: 6px;
        }

        .timer {
            font-family: 'Courier New', monospace;
            font-weight: 600;
            color: var(--primary);
            font-size: 0.95rem;
        }

        .no-tasks {
            text-align: center;
            color: var(--gray);
            padding: 30px 20px;
            font-size: 0.95rem;
        }

        .no-tasks i {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: var(--gray-light);
        }

        @media (max-width: 640px) {
            body {
                padding: 15px;
            }

            h1 {
                font-size: 1.8rem;
                margin: 15px 0 25px;
            }

            .task-form, .task-list, .completed-tasks {
                padding: 20px;
                border-radius: 14px;
            }

            .task-item {
                padding: 16px;
                flex-direction: column;
            }

            .task-actions {
                justify-content: flex-start;
            }

            .btn {
                padding: 10px 16px;
                font-size: 0.9rem;
                margin-right: 8px;
                margin-bottom: 8px;
            }

            .btn-sm {
                padding: 7px 12px;
            }

            .section-title {
                font-size: 1.2rem;
            }
        }

        button:focus, input:focus, .clear-btn:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.3);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .task-item {
            animation: fadeIn 0.3s ease-out forwards;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-tasks"></i> TaskFlow</h1>
        
        <div class="task-form">
            <div class="form-group">
                <label for="task-description">NOVA TAREFA</label>
                <input type="text" id="task-description" placeholder="O que você precisa fazer?">
            </div>
            <button id="add-task" class="btn btn-primary">
                <i class="fas fa-plus"></i> Adicionar Tarefa
            </button>
        </div>
        
        <div class="task-list">
            <h2 class="section-title"><i class="fas fa-clock"></i> Tarefas Ativas</h2>
            <div id="active-tasks"></div>
        </div>
        
        <div class="completed-tasks">
            <div class="completed-header">
                <h2 class="section-title"><i class="fas fa-check-circle"></i> Tarefas Finalizadas</h2>
                <button id="clear-completed" class="clear-btn">
                    <i class="fas fa-trash-alt"></i> Limpar Tudo
                </button>
            </div>
            <div id="completed-tasks"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elementos do DOM
            const taskDescriptionInput = document.getElementById('task-description');
            const addTaskButton = document.getElementById('add-task');
            const activeTasksContainer = document.getElementById('active-tasks');
            const completedTasksContainer = document.getElementById('completed-tasks');
            const clearCompletedButton = document.getElementById('clear-completed');

            // Carregar tarefas do localStorage
            let tasks = JSON.parse(localStorage.getItem('tasks')) || [];
            let activeTimers = {};

            // Inicializar o aplicativo
            function init() {
                // Corrigir timers que estavam rodando antes do fechamento
                tasks.forEach(task => {
                    if (task.isRunning && task.lastStartTime) {
                        // Calcular o tempo que passou desde que a página foi fechada
                        const timeElapsed = Date.now() - task.lastStartTime;
                        task.timeSpent += timeElapsed;
                        task.lastStartTime = Date.now(); // Resetar para agora
                    }
                });
                
                renderActiveTasks();
                renderCompletedTasks();
                restoreRunningTimers();
                
                // Focar no input ao carregar
                taskDescriptionInput.focus();
            }

            // Restaurar timers que estavam rodando antes do fechamento
            function restoreRunningTimers() {
                tasks.forEach(task => {
                    if (task.isRunning) {
                        startTimer(task.id);
                    }
                });
            }

            // Adicionar nova tarefa ao pressionar Enter
            taskDescriptionInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    addTask();
                }
            });

            addTaskButton.addEventListener('click', addTask);

            function addTask() {
                const description = taskDescriptionInput.value.trim();
                if (description) {
                    const newTask = {
                        id: Date.now().toString(),
                        description: description,
                        timeSpent: 0,
                        lastStartTime: null,
                        isRunning: false,
                        isPaused: false,
                        isCompleted: false,
                        completedAt: null,
                        createdAt: Date.now()
                    };
                    
                    tasks.push(newTask);
                    saveTasks();
                    renderActiveTasks();
                    taskDescriptionInput.value = '';
                    taskDescriptionInput.focus();
                }
            }

            // Renderizar tarefas ativas
            function renderActiveTasks() {
                const activeTasks = tasks.filter(task => !task.isCompleted)
                                         .sort((a, b) => b.createdAt - a.createdAt);
                
                if (activeTasks.length === 0) {
                    activeTasksContainer.innerHTML = `
                        <div class="no-tasks">
                            <i class="far fa-clock"></i>
                            <div>Nenhuma tarefa ativa no momento</div>
                        </div>
                    `;
                    return;
                }
                
                activeTasksContainer.innerHTML = '';
                
                activeTasks.forEach(task => {
                    const taskElement = document.createElement('div');
                    taskElement.className = `task-item ${task.isRunning ? 'task-active' : ''}`;
                    taskElement.id = `task-${task.id}`;
                    
                    // Calcular o tempo total considerando se está rodando
                    let totalTime = task.timeSpent;
                    if (task.isRunning && task.lastStartTime) {
                        totalTime += Date.now() - task.lastStartTime;
                    }
                    
                    const timeSpentFormatted = formatTime(totalTime);
                    const createdDate = new Date(task.createdAt).toLocaleDateString();
                    
                    taskElement.innerHTML = `
                        <div class="task-info">
                            <div class="task-title">${task.description}</div>
                            <div class="task-time">
                                <i class="far fa-clock"></i>
                                Tempo: <span class="timer" id="timer-${task.id}">${timeSpentFormatted}</span>
                                <span style="margin: 0 5px">•</span>
                                <i class="far fa-calendar"></i> Criada em: ${createdDate}
                            </div>
                        </div>
                        <div class="task-actions">
                            ${!task.isRunning ? `
                                <button class="btn btn-success btn-sm start-btn" data-id="${task.id}">
                                    <i class="fas fa-play"></i> Play
                                </button>
                            ` : `
                                <button class="btn btn-warning btn-sm pause-btn" data-id="${task.id}">
                                    <i class="fas fa-pause"></i> Pause
                                </button>
                            `}
                            ${task.isRunning || task.timeSpent > 0 ? `
                                <button class="btn btn-danger btn-sm stop-btn" data-id="${task.id}">
                                    <i class="fas fa-stop"></i> Finalizar
                                </button>
                            ` : ''}
                            <button class="btn btn-outline btn-sm delete-btn" data-id="${task.id}">
                                <i class="fas fa-trash-alt"></i> Excluir
                            </button>
                        </div>
                    `;
                    
                    activeTasksContainer.appendChild(taskElement);
                });
                
                // Adicionar event listeners aos botões
                document.querySelectorAll('.start-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const taskId = this.getAttribute('data-id');
                        startTimer(taskId);
                    });
                });
                
                document.querySelectorAll('.pause-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const taskId = this.getAttribute('data-id');
                        pauseTimer(taskId);
                    });
                });
                
                document.querySelectorAll('.stop-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const taskId = this.getAttribute('data-id');
                        stopTimer(taskId);
                    });
                });

                document.querySelectorAll('.delete-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const taskId = this.getAttribute('data-id');
                        deleteTask(taskId);
                    });
                });
            }

            // Renderizar tarefas completadas
            function renderCompletedTasks() {
                const completedTasks = tasks.filter(task => task.isCompleted)
                                           .sort((a, b) => new Date(b.completedAt) - new Date(a.completedAt));
                
                if (completedTasks.length === 0) {
                    completedTasksContainer.innerHTML = `
                        <div class="no-tasks">
                            <i class="far fa-check-circle"></i>
                            <div>Nenhuma tarefa completada ainda</div>
                        </div>
                    `;
                    return;
                }
                
                completedTasksContainer.innerHTML = '';
                
                completedTasks.forEach(task => {
                    const taskElement = document.createElement('div');
                    taskElement.className = 'task-item';
                    
                    const completedDate = new Date(task.completedAt).toLocaleString();
                    const createdDate = new Date(task.createdAt).toLocaleDateString();
                    const timeSpentFormatted = formatTime(task.timeSpent);
                    
                    taskElement.innerHTML = `
                        <div class="task-info">
                            <div class="task-title">${task.description}</div>
                            <div class="task-time">
                                <i class="far fa-clock"></i>
                                Tempo total: ${timeSpentFormatted}
                                <span style="margin: 0 5px">•</span>
                                <i class="far fa-calendar-check"></i> Finalizada em: ${completedDate}
                                <span style="margin: 0 5px">•</span>
                                <i class="far fa-calendar"></i> Criada em: ${createdDate}
                            </div>
                        </div>
                        <div class="task-actions">
                            <button class="btn btn-outline btn-sm delete-btn" data-id="${task.id}">
                                <i class="fas fa-trash-alt"></i> Excluir
                            </button>
                        </div>
                    `;
                    
                    completedTasksContainer.appendChild(taskElement);
                });

                // Adicionar event listeners aos botões de exclusão
                document.querySelectorAll('.delete-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const taskId = this.getAttribute('data-id');
                        deleteTask(taskId);
                    });
                });
            }

            // Iniciar timer
            function startTimer(taskId) {
                const taskIndex = tasks.findIndex(task => task.id === taskId);
                if (taskIndex === -1) return;
                
                // Pausar qualquer outro timer que esteja rodando
                tasks.forEach((t, i) => {
                    if (t.isRunning && t.id !== taskId) {
                        pauseTimer(t.id);
                    }
                });
                
                tasks[taskIndex].isRunning = true;
                tasks[taskIndex].isPaused = false;
                tasks[taskIndex].lastStartTime = Date.now();
                
                saveTasks();
                renderActiveTasks();
                
                // Atualizar o timer a cada segundo
                if (activeTimers[taskId]) {
                    clearInterval(activeTimers[taskId]);
                }
                
                activeTimers[taskId] = setInterval(() => {
                    updateTimerDisplay(taskId);
                }, 1000);
            }

            // Pausar timer
            function pauseTimer(taskId) {
                const taskIndex = tasks.findIndex(task => task.id === taskId);
                if (taskIndex === -1) return;
                
                if (tasks[taskIndex].isRunning && tasks[taskIndex].lastStartTime) {
                    tasks[taskIndex].timeSpent += Date.now() - tasks[taskIndex].lastStartTime;
                }
                
                tasks[taskIndex].isRunning = false;
                tasks[taskIndex].isPaused = true;
                tasks[taskIndex].lastStartTime = null;
                
                saveTasks();
                renderActiveTasks();
                
                if (activeTimers[taskId]) {
                    clearInterval(activeTimers[taskId]);
                    delete activeTimers[taskId];
                }
            }

            // Parar timer e marcar como completada
            function stopTimer(taskId) {
                const taskIndex = tasks.findIndex(task => task.id === taskId);
                if (taskIndex === -1) return;
                
                if (tasks[taskIndex].isRunning && tasks[taskIndex].lastStartTime) {
                    tasks[taskIndex].timeSpent += Date.now() - tasks[taskIndex].lastStartTime;
                }
                
                tasks[taskIndex].isRunning = false;
                tasks[taskIndex].isCompleted = true;
                tasks[taskIndex].completedAt = Date.now();
                
                saveTasks();
                
                if (activeTimers[taskId]) {
                    clearInterval(activeTimers[taskId]);
                    delete activeTimers[taskId];
                }
                
                renderActiveTasks();
                renderCompletedTasks();
            }

            // Excluir uma tarefa específica
            function deleteTask(taskId) {
                if (confirm('Tem certeza que deseja excluir esta tarefa?')) {
                    // Parar o timer se estiver rodando
                    if (activeTimers[taskId]) {
                        clearInterval(activeTimers[taskId]);
                        delete activeTimers[taskId];
                    }
                    
                    // Remover a tarefa do array
                    tasks = tasks.filter(task => task.id !== taskId);
                    saveTasks();
                    
                    // Renderizar novamente as listas
                    renderActiveTasks();
                    renderCompletedTasks();
                }
            }

            // Atualizar display do timer
            function updateTimerDisplay(taskId) {
                const task = tasks.find(task => task.id === taskId);
                if (!task) return;
                
                const timerElement = document.getElementById(`timer-${taskId}`);
                if (timerElement) {
                    let totalTime = task.timeSpent;
                    if (task.isRunning && task.lastStartTime) {
                        totalTime += Date.now() - task.lastStartTime;
                    }
                    timerElement.textContent = formatTime(totalTime);
                }
            }

            // Limpar tarefas completadas
            clearCompletedButton.addEventListener('click', function() {
                if (confirm('Tem certeza que deseja limpar todas as tarefas completadas?')) {
                    // Parar todos os timers das tarefas completadas (caso existam)
                    tasks.filter(task => task.isCompleted).forEach(task => {
                        if (activeTimers[task.id]) {
                            clearInterval(activeTimers[task.id]);
                            delete activeTimers[task.id];
                        }
                    });
                    
                    tasks = tasks.filter(task => !task.isCompleted);
                    saveTasks();
                    renderCompletedTasks();
                }
            });

            // Formatar tempo (hh:mm:ss)
            function formatTime(milliseconds) {
                const totalSeconds = Math.floor(milliseconds / 1000);
                const hours = Math.floor(totalSeconds / 3600);
                const minutes = Math.floor((totalSeconds % 3600) / 60);
                const seconds = totalSeconds % 60;
                
                return [
                    hours.toString().padStart(2, '0'),
                    minutes.toString().padStart(2, '0'),
                    seconds.toString().padStart(2, '0')
                ].join(':');
            }

            // Salvar tarefas no localStorage
            function saveTasks() {
                localStorage.setItem('tasks', JSON.stringify(tasks));
            }

            // Inicializar o app
            init();
        });
    </script>
</body>
</html>
