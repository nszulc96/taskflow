<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>TaskFlow - Gestor de Tarefas</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary-color: #4e73df;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --dark-color: #5a5c69;
        }

        body {
            background-color: #f8f9fc;
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--primary-color);
        }

        .card {
            border: none;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            font-weight: 700;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-success {
            background-color: var(--success-color);
            border-color: var(--success-color);
        }

        .btn-danger {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
        }

        .status-badge {
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 700;
            border-radius: 0.25rem;
        }

        .status-progress {
            background-color: #f8f4e6;
            color: #856404;
        }

        .status-started {
            background-color: #e6f4f8;
            color: #0c5460;
        }

        .status-completed {
            background-color: #e6f8ed;
            color: #155724;
        }

        .task-table th {
            border-top: none;
            font-weight: 700;
            color: var(--dark-color);
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 0.05em;
        }

        .task-row:hover {
            background-color: #f8f9fc;
        }

        .project-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .project-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1.5rem 0 rgba(58, 59, 69, 0.2);
        }

        .timer {
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: var(--dark-color);
        }

        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, var(--primary-color) 10%, #224abe 100%);
            color: white;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 600;
            padding: 0.75rem 1rem;
        }

        .sidebar .nav-link:hover {
            color: white;
        }

        .sidebar .nav-link i {
            margin-right: 0.5rem;
        }

        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .progress-thin {
            height: 5px;
        }

        .task-priority-high {
            border-left: 4px solid var(--danger-color);
        }

        .task-priority-medium {
            border-left: 4px solid var(--warning-color);
        }

        .task-priority-low {
            border-left: 4px solid var(--success-color);
        }

        .task-actions .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            line-height: 1.5;
            border-radius: 0.2rem;
        }

        .task-actions .btn i {
            margin-right: 0;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block sidebar collapse bg-primary">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white">TaskFlow</h4>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#" id="show-all-tasks">
                                <i class="fas fa-tasks"></i>
                                Todas as Tarefas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="show-projects">
                                <i class="fas fa-project-diagram"></i>
                                Projetos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="show-stats">
                                <i class="fas fa-chart-pie"></i>
                                Estatísticas
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2" id="page-title">Todas as Tarefas</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                            <i class="fas fa-plus me-1"></i> Nova Tarefa
                        </button>
                        <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                            <i class="fas fa-project-diagram me-1"></i> Novo Projeto
                        </button>
                    </div>
                </div>

                <!-- All Tasks View -->
                <div class="card mb-4" id="all-tasks-view">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-tasks me-2"></i> Todas as Tarefas</span>
                        <div class="form-group mb-0" style="width: 200px;">
                            <select class="form-control form-control-sm" id="filter-project">
                                <option value="">Todos os projetos</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover task-table" id="tasks-table">
                                <thead>
                                    <tr>
                                        <th width="30%">Tarefa</th>
                                        <th width="15%">Projeto</th>
                                        <th width="10%">Prioridade</th>
                                        <th width="10%">Status</th>
                                        <th width="15%">Tempo</th>
                                        <th width="15%">Data</th>
                                        <th width="5%">Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="all-tasks">
                                    <!-- Tasks will be loaded here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Projects View (Hidden by default) -->
                <div class="card mb-4 d-none" id="projects-view">
                    <div class="card-header">
                        <i class="fas fa-project-diagram me-2"></i> Projetos
                    </div>
                    <div class="card-body">
                        <div class="row" id="projects-container">
                            <!-- Projects will be loaded here -->
                        </div>
                    </div>
                </div>

                <!-- Statistics View (Hidden by default) -->
                <div class="card mb-4 d-none" id="stats-view">
                    <div class="card-header">
                        <i class="fas fa-chart-pie me-2"></i> Estatísticas
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mb-3">Tempo por Projeto</h5>
                                <div id="projects-chart" style="height: 300px;"></div>
                            </div>
                            <div class="col-md-6">
                                <h5 class="mb-3">Status das Tarefas</h5>
                                <div id="status-chart" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Add Task Modal -->
    <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTaskModalLabel">Nova Tarefa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form-add-task">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="task-project" class="form-label">Projeto</label>
                            <select class="form-select" id="task-project" name="project" required>
                                <option value="">Selecione um projeto</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="task-name" class="form-label">Nome da Tarefa</label>
                            <input type="text" class="form-control" id="task-name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="task-description" class="form-label">Descrição (Opcional)</label>
                            <textarea class="form-control" id="task-description" name="description" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="task-priority" class="form-label">Prioridade</label>
                                <select class="form-select" id="task-priority" name="priority">
                                    <option value="low">Baixa</option>
                                    <option value="medium" selected>Média</option>
                                    <option value="high">Alta</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="task-due-date" class="form-label">Data de Vencimento (Opcional)</label>
                                <input type="date" class="form-control" id="task-due-date" name="due_date">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Adicionar Tarefa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Project Modal -->
    <div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProjectModalLabel">Novo Projeto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form-add-project">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="project-name" class="form-label">Nome do Projeto</label>
                            <input type="text" class="form-control" id="project-name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="project-description" class="form-label">Descrição (Opcional)</label>
                            <textarea class="form-control" id="project-description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="project-color" class="form-label">Cor do Projeto</label>
                            <input type="color" class="form-control form-control-color" id="project-color" name="color" value="#4e73df">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Adicionar Projeto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Task Details Modal -->
    <div class="modal fade" id="taskDetailsModal" tabindex="-1" aria-labelledby="taskDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskDetailsModalLabel">Detalhes da Tarefa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="task-details-content">
                    <!-- Task details will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="delete-confirm-message">
                    Tem certeza que deseja excluir este item?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirm-delete-btn">Excluir</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/luxon@3.0.1"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@1.0.0"></script>

    <script>
        // Main Task Manager Object
        const TaskManager = {
            // Local storage keys
            storageKeys: {
                projects: 'taskflow_projects',
                tasks: 'taskflow_tasks'
            },

            // Initialize the application
            init: function() {
                this.initStorage();
                this.loadProjects();
                this.loadTasks();
                this.setupEventListeners();
                this.updateStatsCharts();

                // Update running tasks every second
                setInterval(() => this.updateRunningTasks(), 1000);
            },

            // Initialize local storage if empty
            initStorage: function() {
                if (!localStorage.getItem(this.storageKeys.projects)) {
                    localStorage.setItem(this.storageKeys.projects, JSON.stringify([]));
                }
                if (!localStorage.getItem(this.storageKeys.tasks)) {
                    localStorage.setItem(this.storageKeys.tasks, JSON.stringify([]));
                }
            },

            // Load all projects from storage
            loadProjects: function() {
                const projects = JSON.parse(localStorage.getItem(this.storageKeys.projects));

                // Populate project dropdowns
                const projectDropdowns = [
                    document.getElementById('task-project'),
                    document.getElementById('filter-project')
                ];

                projectDropdowns.forEach(dropdown => {
                    if (dropdown) {
                        dropdown.innerHTML = '<option value="">Selecione um projeto</option>' +
                            projects.map(project =>
                                `<option value="${project.id}">${project.name}</option>`
                            ).join('');
                    }
                });

                // Render projects view
                this.renderProjectsView(projects);

                return projects;
            },

            // Load all tasks from storage
            loadTasks: function(filterProjectId = '') {
                let tasks = JSON.parse(localStorage.getItem(this.storageKeys.tasks));

                // Filter tasks by project if specified
                if (filterProjectId) {
                    tasks = tasks.filter(task => task.projectId === filterProjectId);
                }

                // Sort tasks: started first, then by due date, then by priority
                tasks.sort((a, b) => {
                    // Started tasks first
                    if (a.isStarted && !b.isStarted) return -1;
                    if (!a.isStarted && b.isStarted) return 1;

                    // Then by due date (earlier first)
                    if (a.dueDate && b.dueDate) {
                        return new Date(a.dueDate) - new Date(b.dueDate);
                    } else if (a.dueDate) {
                        return -1;
                    } else if (b.dueDate) {
                        return 1;
                    }

                    // Then by priority (high first)
                    const priorityOrder = {
                        high: 3,
                        medium: 2,
                        low: 1
                    };
                    return priorityOrder[b.priority] - priorityOrder[a.priority];
                });

                // Render tasks
                this.renderTasksView(tasks);

                return tasks;
            },

            // Render projects in the projects view
            renderProjectsView: function(projects) {
                const container = document.getElementById('projects-container');
                if (!container) return;

                container.innerHTML = projects.map(project => `
                    <div class="col-md-4 mb-4">
                        <div class="card project-card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title mb-0" style="color: ${project.color || '#4e73df'}">
                                        ${project.name}
                                    </h5>
                                    <span class="badge bg-primary rounded-pill">
                                        ${this.getTasksByProject(project.id).length}
                                    </span>
                                </div>
                                <p class="card-text text-muted small">${project.description || 'Sem descrição'}</p>

                                <div class="progress progress-thin mb-3">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: ${this.getProjectCompletion(project.id)}%; background-color: ${project.color || '#4e73df'}"
                                        aria-valuenow="${this.getProjectCompletion(project.id)}"
                                        aria-valuemin="0"
                                        aria-valuemax="100">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">
                                        ${this.getProjectTimeSpent(project.id)}
                                    </small>
                                    <div>
                                        <button class="btn btn-sm btn-outline-primary me-1 edit-project" data-id="${project.id}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger delete-project" data-id="${project.id}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `).join('');

                // Add event listeners to project cards
                document.querySelectorAll('.project-card').forEach(card => {
                    card.addEventListener('click', (e) => {
                        if (!e.target.closest('button')) {
                            const projectId = card.querySelector('.edit-project').dataset.id;
                            this.loadTasks(projectId);
                            document.getElementById('filter-project').value = projectId;
                            this.showView('all-tasks-view');
                        }
                    });
                });
            },

            // Render tasks in the tasks view
            renderTasksView: function(tasks) {
                const container = document.getElementById('all-tasks');
                if (!container) return;

                container.innerHTML = tasks.map(task => {
                    const project = this.getProjectById(task.projectId);
                    const priorityClass = `task-priority-${task.priority}`;

                    // Calculate duration
                    const duration = this.calculateTaskDuration(task);
                    const durationFormatted = this.formatDuration(duration);

                    // Due date warning
                    let dueDateWarning = '';
                    if (task.dueDate) {
                        const dueDate = new Date(task.dueDate);
                        const today = new Date();
                        today.setHours(0, 0, 0, 0);

                        if (dueDate < today) {
                            dueDateWarning = '<span class="badge bg-danger ms-2">Atrasada</span>';
                        } else if (dueDate.toDateString() === today.toDateString()) {
                            dueDateWarning = '<span class="badge bg-warning text-dark ms-2">Hoje</span>';
                        }
                    }

                    return `
                        <tr class="${priorityClass} task-row" data-id="${task.id}">
                            <td>
                                <strong>${task.name}</strong>
                                ${task.description ? `<small class="d-block text-muted">${task.description}</small>` : ''}
                            </td>
                            <td>
                                <span class="badge rounded-pill" style="background-color: ${project?.color || '#4e73df'}">
                                    ${project?.name || 'Sem projeto'}
                                </span>
                            </td>
                            <td>
                                ${this.getPriorityBadge(task.priority)}
                            </td>
                            <td>
                                ${this.getStatusBadge(task)}
                            </td>
                            <td class="timer">
                                ${durationFormatted}
                                ${task.isStarted ? '<span class="badge bg-success ms-2">Rodando</span>' : ''}
                            </td>
                            <td>
                                ${task.dueDate ? new Date(task.dueDate).toLocaleDateString() : '-'}
                                ${dueDateWarning}
                            </td>
                            <td class="text-nowrap task-actions">
                                <button class="btn btn-sm btn-outline-primary me-1 view-task" data-id="${task.id}" title="Ver detalhes">
                                    <i class="fas fa-eye"></i>
                                </button>
                                ${!task.isStarted && task.status !== 'completed' ? `
                                <button class="btn btn-sm btn-outline-success me-1 start-task" data-id="${task.id}" title="Iniciar">
                                    <i class="fas fa-play"></i>
                                </button>
                                ` : ''}
                                ${task.isStarted ? `
                                <button class="btn btn-sm btn-outline-warning me-1 stop-task" data-id="${task.id}" title="Parar">
                                    <i class="fas fa-stop"></i>
                                </button>
                                ` : ''}
                                ${task.status !== 'completed' ? `
                                <button class="btn btn-sm btn-outline-info me-1 complete-task" data-id="${task.id}" title="Completar">
                                    <i class="fas fa-check"></i>
                                </button>
                                ` : `
                                <button class="btn btn-sm btn-outline-secondary me-1 reopen-task" data-id="${task.id}" title="Reabrir">
                                    <i class="fas fa-redo"></i>
                                </button>
                                `}
                                <button class="btn btn-sm btn-outline-danger delete-task" data-id="${task.id}" title="Excluir">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                }).join('');

                // Add event listeners to task actions
                this.setupTaskActionListeners();
            },

            // Get priority badge HTML
            getPriorityBadge: function(priority) {
                const badges = {
                    high: '<span class="badge bg-danger">Alta</span>',
                    medium: '<span class="badge bg-warning text-dark">Média</span>',
                    low: '<span class="badge bg-success">Baixa</span>'
                };
                return badges[priority] || '';
            },

            // Get status badge HTML
            getStatusBadge: function(task) {
                if (task.status === 'completed') {
                    return '<span class="status-badge status-completed">Concluída</span>';
                } else if (task.isStarted) {
                    return '<span class="status-badge status-started">Em andamento</span>';
                } else {
                    return '<span class="status-badge status-progress">Pendente</span>';
                }
            },

            // Format duration (seconds) to HH:MM:SS
            formatDuration: function(duration) {
                const hours = Math.floor(duration / 3600) % 24;
                const minutes = Math.floor(duration / 60) % 60;
                const seconds = duration % 60;

                return [
                    hours.toString().padStart(2, '0'),
                    minutes.toString().padStart(2, '0'),
                    seconds.toString().padStart(2, '0')
                ].join(':');
            },

            // Calculate total duration of a task from its logs
            calculateTaskDuration: function(task) {
                let duration = 0;

                if (task.logs) {
                    task.logs.forEach(log => {
                        if (log.endTime) {
                            duration += (log.endTime - log.startTime) / 1000;
                        } else {
                            duration += (Date.now() - log.startTime) / 1000;
                        }
                    });
                }

                return Math.floor(duration);
            },

            // Get project by ID
            getProjectById: function(id) {
                const projects = JSON.parse(localStorage.getItem(this.storageKeys.projects));
                return projects.find(project => project.id === id);
            },

            // Get tasks by project ID
            getTasksByProject: function(projectId) {
                const tasks = JSON.parse(localStorage.getItem(this.storageKeys.tasks));
                return tasks.filter(task => task.projectId === projectId);
            },

            // Get project completion percentage
            getProjectCompletion: function(projectId) {
                const tasks = this.getTasksByProject(projectId);
                if (tasks.length === 0) return 0;

                const completedTasks = tasks.filter(task => task.status === 'completed').length;
                return Math.round((completedTasks / tasks.length) * 100);
            },

            // Get total time spent on project
            getProjectTimeSpent: function(projectId) {
                const tasks = this.getTasksByProject(projectId);
                let totalSeconds = 0;

                tasks.forEach(task => {
                    totalSeconds += this.calculateTaskDuration(task);
                });

                const hours = Math.floor(totalSeconds / 3600);
                const minutes = Math.floor((totalSeconds % 3600) / 60);

                if (hours > 0) {
                    return `${hours}h ${minutes}m`;
                } else {
                    return `${minutes}m`;
                }
            },

            // Add a new project
            addProject: function(formData) {
                const projects = JSON.parse(localStorage.getItem(this.storageKeys.projects));

                const newProject = {
                    id: Date.now().toString(),
                    name: formData.name,
                    description: formData.description,
                    color: formData.color,
                    createdAt: new Date().toISOString()
                };

                projects.push(newProject);
                localStorage.setItem(this.storageKeys.projects, JSON.stringify(projects));

                this.loadProjects();
                this.showToast('Projeto adicionado com sucesso!', 'success');
            },

            // Add a new task
            addTask: function(formData) {
                const tasks = JSON.parse(localStorage.getItem(this.storageKeys.tasks));

                const newTask = {
                    id: Date.now().toString(),
                    projectId: formData.project,
                    name: formData.name,
                    description: formData.description,
                    priority: formData.priority,
                    dueDate: formData.due_date,
                    status: 'pending',
                    isStarted: false,
                    logs: [],
                    createdAt: new Date().toISOString(),
                    startedAt: '',
                    completedAt: ''
                };

                tasks.push(newTask);
                localStorage.setItem(this.storageKeys.tasks, JSON.stringify(tasks));

                this.loadTasks();
                this.showToast('Tarefa adicionada com sucesso!', 'success');
            },

            // Start a task
            startTask: function(taskId) {
                const tasks = JSON.parse(localStorage.getItem(this.storageKeys.tasks));
                const task = tasks.find(t => t.id === taskId);

                if (task) {
                    // Stop any other running tasks first
                    this.stopAllRunningTasks();

                    task.isStarted = true;
                    task.status = 'in-progress';
                    task.startedAt = new Date().toISOString();

                    // Add new log entry
                    if (!task.logs) task.logs = [];
                    task.logs.push({
                        id: Date.now().toString(),
                        startTime: Date.now(),
                        endTime: 0
                    });

                    localStorage.setItem(this.storageKeys.tasks, JSON.stringify(tasks));
                    this.loadTasks();
                    this.showToast('Tarefa iniciada!', 'success');
                }
            },

            // Stop a task
            stopTask: function(taskId) {
                const tasks = JSON.parse(localStorage.getItem(this.storageKeys.tasks));
                const task = tasks.find(t => t.id === taskId);

                if (task && task.isStarted) {
                    task.isStarted = false;

                    // Update the last log entry
                    if (task.logs && task.logs.length > 0) {
                        const lastLog = task.logs[task.logs.length - 1];
                        if (lastLog.endTime === 0) {
                            lastLog.endTime = Date.now();
                        }
                    }

                    localStorage.setItem(this.storageKeys.tasks, JSON.stringify(tasks));
                    this.loadTasks();
                    this.showToast('Tarefa parada!', 'info');
                }
            },

            // Stop all running tasks
            stopAllRunningTasks: function() {
                const tasks = JSON.parse(localStorage.getItem(this.storageKeys.tasks));
                let updated = false;

                tasks.forEach(task => {
                    if (task.isStarted) {
                        task.isStarted = false;

                        // Update the last log entry
                        if (task.logs && task.logs.length > 0) {
                            const lastLog = task.logs[task.logs.length - 1];
                            if (lastLog.endTime === 0) {
                                lastLog.endTime = Date.now();
                                updated = true;
                            }
                        }
                    }
                });

                if (updated) {
                    localStorage.setItem(this.storageKeys.tasks, JSON.stringify(tasks));
                    this.loadTasks();
                }
            },

            // Mark task as completed
            completeTask: function(taskId) {
                const tasks = JSON.parse(localStorage.getItem(this.storageKeys.tasks));
                const task = tasks.find(t => t.id === taskId);

                if (task) {
                    // Stop the task if it's running
                    if (task.isStarted) {
                        task.isStarted = false;

                        // Update the last log entry
                        if (task.logs && task.logs.length > 0) {
                            const lastLog = task.logs[task.logs.length - 1];
                            if (lastLog.endTime === 0) {
                                lastLog.endTime = Date.now();
                            }
                        }
                    }

                    task.status = 'completed';
                    task.completedAt = new Date().toISOString();

                    localStorage.setItem(this.storageKeys.tasks, JSON.stringify(tasks));
                    this.loadTasks();
                    this.showToast('Tarefa completada! Parabéns!', 'success');
                }
            },

            // Reopen a completed task
            reopenTask: function(taskId) {
                const tasks = JSON.parse(localStorage.getItem(this.storageKeys.tasks));
                const task = tasks.find(t => t.id === taskId);

                if (task) {
                    task.status = 'pending';
                    task.completedAt = '';

                    localStorage.setItem(this.storageKeys.tasks, JSON.stringify(tasks));
                    this.loadTasks();
                    this.showToast('Tarefa reaberta!', 'info');
                }
            },

            // Delete a task
            deleteTask: function(taskId) {
                const tasks = JSON.parse(localStorage.getItem(this.storageKeys.tasks));
                const updatedTasks = tasks.filter(task => task.id !== taskId);

                localStorage.setItem(this.storageKeys.tasks, JSON.stringify(updatedTasks));
                this.loadTasks();
                this.showToast('Tarefa excluída!', 'info');
            },

            // Delete a project
            deleteProject: function(projectId) {
                // First confirm that the project has no tasks
                const projectTasks = this.getTasksByProject(projectId);

                if (projectTasks.length > 0) {
                    this.showToast('Não é possível excluir um projeto com tarefas!', 'error');
                    return;
                }

                // Delete the project
                const projects = JSON.parse(localStorage.getItem(this.storageKeys.projects));
                const updatedProjects = projects.filter(project => project.id !== projectId);

                localStorage.setItem(this.storageKeys.projects, JSON.stringify(updatedProjects));
                this.loadProjects();
                this.showToast('Projeto excluído!', 'info');
            },

            // Show task details
            showTaskDetails: function(taskId) {
                const tasks = JSON.parse(localStorage.getItem(this.storageKeys.tasks));
                const task = tasks.find(t => t.id === taskId);

                if (task) {
                    const project = this.getProjectById(task.projectId);
                    const duration = this.formatDuration(this.calculateTaskDuration(task));

                    let logsHtml = '';
                    if (task.logs && task.logs.length > 0) {
                        logsHtml = `
                            <h6 class="mt-4">Registro de Tempo</h6>
                            <ul class="list-group">
                                ${task.logs.map(log => `
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>
                                            ${new Date(log.startTime).toLocaleString()}
                                            ${log.endTime ? ` até ${new Date(log.endTime).toLocaleString()}` : ''}
                                        </span>
                                        <span class="badge bg-primary rounded-pill">
                                            ${log.endTime ?
                                                this.formatDuration((log.endTime - log.startTime) / 1000) :
                                                'Em andamento'}
                                        </span>
                                    </li>
                                `).join('')}
                            </ul>
                        `;
                    }

                    document.getElementById('task-details-content').innerHTML = `
                        <h5>${task.name}</h5>
                        <p class="text-muted">${task.description || 'Sem descrição'}</p>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <p><strong>Projeto:</strong> ${project?.name || 'Sem projeto'}</p>
                                <p><strong>Prioridade:</strong> ${this.getPriorityBadge(task.priority)}</p>
                                <p><strong>Status:</strong> ${this.getStatusBadge(task)}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Criada em:</strong> ${new Date(task.createdAt).toLocaleString()}</p>
                                ${task.startedAt ? `
                                    <p><strong>Iniciada em:</strong> ${new Date(task.startedAt).toLocaleString()}</p>
                                ` : ''}
                                ${task.completedAt ? `
                                    <p><strong>Completada em:</strong> ${new Date(task.completedAt).toLocaleString()}</p>
                                ` : ''}
                                ${task.dueDate ? `
                                    <p><strong>Vencimento:</strong> ${new Date(task.dueDate).toLocaleDateString()}</p>
                                ` : ''}
                            </div>
                        </div>

                        <div class="alert alert-info mt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span><strong>Tempo total:</strong> ${duration}</span>
                                ${task.isStarted ? `
                                    <span class="badge bg-success">Em andamento</span>
                                ` : ''}
                            </div>
                        </div>

                        ${logsHtml}
                    `;

                    const modal = new bootstrap.Modal(document.getElementById('taskDetailsModal'));
                    modal.show();
                }
            },

            // Update running tasks timer
            updateRunningTasks: function() {
                const tasks = JSON.parse(localStorage.getItem(this.storageKeys.tasks));
                const runningTasks = tasks.filter(task => task.isStarted);

                if (runningTasks.length > 0) {
                    runningTasks.forEach(task => {
                        const taskRow = document.querySelector(`.task-row[data-id="${task.id}"]`);
                        if (taskRow) {
                            const duration = this.calculateTaskDuration(task);
                            const durationFormatted = this.formatDuration(duration);

                            const timerCell = taskRow.querySelector('.timer');
                            if (timerCell) {
                                timerCell.innerHTML = `${durationFormatted} <span class="badge bg-success ms-2">Rodando</span>`;
                            }
                        }
                    });
                }
            },

            // Update statistics charts
            updateStatsCharts: function() {
                const projects = JSON.parse(localStorage.getItem(this.storageKeys.projects));
                const tasks = JSON.parse(localStorage.getItem(this.storageKeys.tasks));

                // Projects time chart
                const projectsChartCtx = document.getElementById('projects-chart');
                if (projectsChartCtx) {
                    const projectsData = projects.map(project => {
                        const projectTasks = tasks.filter(task => task.projectId === project.id);
                        let totalSeconds = 0;

                        projectTasks.forEach(task => {
                            totalSeconds += this.calculateTaskDuration(task);
                        });

                        return {
                            name: project.name,
                            time: totalSeconds / 3600, // Convert to hours
                            color: project.color || '#4e73df'
                        };
                    });

                    new Chart(projectsChartCtx, {
                        type: 'bar',
                        data: {
                            labels: projectsData.map(p => p.name),
                            datasets: [{
                                label: 'Horas por Projeto',
                                data: projectsData.map(p => p.time),
                                backgroundColor: projectsData.map(p => p.color),
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Horas'
                                    }
                                }
                            }
                        }
                    });
                }

                // Tasks status chart
                const statusChartCtx = document.getElementById('status-chart');
                if (statusChartCtx) {
                    const statusCounts = {
                        completed: tasks.filter(t => t.status === 'completed').length,
                        inProgress: tasks.filter(t => t.status === 'in-progress').length,
                        pending: tasks.filter(t => t.status === 'pending').length
                    };

                    new Chart(statusChartCtx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Completadas', 'Em andamento', 'Pendentes'],
                            datasets: [{
                                data: [statusCounts.completed, statusCounts.inProgress, statusCounts.pending],
                                backgroundColor: [
                                    '#1cc88a',
                                    '#36b9cc',
                                    '#f6c23e'
                                ],
                                hoverBackgroundColor: [
                                    '#17a673',
                                    '#2c9faf',
                                    '#dda20a'
                                ],
                                hoverBorderColor: "rgba(234, 236, 244, 1)",
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                }
            },

            // Show a toast notification
            showToast: function(message, type = 'success') {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                Toast.fire({
                    icon: type,
                    title: message
                });
            },

            // Show a specific view
            showView: function(viewId) {
                document.getElementById('all-tasks-view').classList.add('d-none');
                document.getElementById('projects-view').classList.add('d-none');
                document.getElementById('stats-view').classList.add('d-none');

                document.getElementById(viewId).classList.remove('d-none');

                // Update page title
                const titles = {
                    'all-tasks-view': 'Todas as Tarefas',
                    'projects-view': 'Projetos',
                    'stats-view': 'Estatísticas'
                };

                document.getElementById('page-title').textContent = titles[viewId];

                // Update charts when showing stats view
                if (viewId === 'stats-view') {
                    this.updateStatsCharts();
                }
            },

            // Setup event listeners
            setupEventListeners: function() {
                // Navigation
                document.getElementById('show-all-tasks').addEventListener('click', (e) => {
                    e.preventDefault();
                    this.showView('all-tasks-view');
                });

                document.getElementById('show-projects').addEventListener('click', (e) => {
                    e.preventDefault();
                    this.showView('projects-view');
                });

                document.getElementById('show-stats').addEventListener('click', (e) => {
                    e.preventDefault();
                    this.showView('stats-view');
                });

                // Project filter
                document.getElementById('filter-project').addEventListener('change', (e) => {
                    this.loadTasks(e.target.value);
                });

                // Add project form
                document.getElementById('form-add-project').addEventListener('submit', (e) => {
                    e.preventDefault();
                    const formData = {
                        name: e.target.name.value,
                        description: e.target.description.value,
                        color: e.target.color.value
                    };

                    this.addProject(formData);
                    bootstrap.Modal.getInstance(document.getElementById('addProjectModal')).hide();
                    e.target.reset();
                });

                // Add task form
                document.getElementById('form-add-task').addEventListener('submit', (e) => {
                    e.preventDefault();
                    const formData = {
                        project: e.target.project.value,
                        name: e.target.name.value,
                        description: e.target.description.value,
                        priority: e.target.priority.value,
                        due_date: e.target.due_date.value
                    };

                    this.addTask(formData);
                    bootstrap.Modal.getInstance(document.getElementById('addTaskModal')).hide();
                    e.target.reset();
                });

                // Project actions
                document.addEventListener('click', (e) => {
                    if (e.target.classList.contains('delete-project') ||
                        e.target.closest('.delete-project')) {
                        e.preventDefault();
                        const projectId = e.target.dataset.id || e.target.closest('.delete-project').dataset.id;

                        // Show confirmation modal
                        document.getElementById('delete-confirm-message').innerHTML = `
                            Tem certeza que deseja excluir este projeto? Esta ação não pode ser desfeita.
                        `;

                        const confirmBtn = document.getElementById('confirm-delete-btn');
                        confirmBtn.onclick = () => {
                            this.deleteProject(projectId);
                            bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal')).hide();
                        };

                        const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
                        modal.show();
                    }
                });
            },

            // Setup task action listeners
            setupTaskActionListeners: function() {
                document.addEventListener('click', (e) => {
                    const taskId = e.target.dataset.id || e.target.closest('[data-id]')?.dataset.id;
                    if (!taskId) return;

                    if (e.target.classList.contains('view-task') ||
                        e.target.closest('.view-task')) {
                        e.preventDefault();
                        this.showTaskDetails(taskId);
                    } else if (e.target.classList.contains('start-task') ||
                        e.target.closest('.start-task')) {
                        e.preventDefault();
                        this.startTask(taskId);
                    } else if (e.target.classList.contains('stop-task') ||
                        e.target.closest('.stop-task')) {
                        e.preventDefault();
                        this.stopTask(taskId);
                    } else if (e.target.classList.contains('complete-task') ||
                        e.target.closest('.complete-task')) {
                        e.preventDefault();
                        this.completeTask(taskId);
                    } else if (e.target.classList.contains('reopen-task') ||
                        e.target.closest('.reopen-task')) {
                        e.preventDefault();
                        this.reopenTask(taskId);
                    } else if (e.target.classList.contains('delete-task') ||
                        e.target.closest('.delete-task')) {
                        e.preventDefault();

                        // Show confirmation modal
                        document.getElementById('delete-confirm-message').innerHTML = `
                            Tem certeza que deseja excluir esta tarefa? Esta ação não pode ser desfeita.
                        `;

                        const confirmBtn = document.getElementById('confirm-delete-btn');
                        confirmBtn.onclick = () => {
                            this.deleteTask(taskId);
                            bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal')).hide();
                        };

                        const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
                        modal.show();
                    }
                });
            }
        };

        // Initialize the application when the DOM is loaded
        document.addEventListener('DOMContentLoaded', () => TaskManager.init());
    </script>
</body>

</html>