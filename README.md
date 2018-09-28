# TODO List
This is a small project to understand and practice how to create an Rest API.

The project is created with **Laravel Framework 5.7.5** and **PHP 7.2.4**

### Steps to install the project:
1. Create your database and configure your .env file
2. Install **Composer**
3. Run **composer install**

Use these endpoints:

### USER EndPoints

#### For get all users
GET: api/json/v1/users

#### For get all users with its todos and/or its tasks
GET: api/json/v1/users?include=todos,tasks,todoComments,taskComments,tasksAssigned

#### For create a new user
POST: api/json/v1/users
BODY: {
    name: juan.flores,
    email: juancfg_18@hotmail.com,
    password: secret
}

#### For update an specific user
PUT/PATCH: api/json/v1/users/{user_id}
BODY: {
    email: juancfg18@gmail.com,
    password: differentsecret
}

#### For get one specific user
GET: api/json/v1/users/{user_id}

#### For get one specific user with his todos and/or tasks
GET: api/json/v1/users/{user_id}?include=todos,tasks

#### Delete an specific user
DELETE: api/json/v1/users/{user_id}

### TODO EndPoints
#### For get all todos
GET: api/json/v1/todos

#### For get all todos with his user owner and/or its tasks
GET: api/json/v1/todos?include=user,tasks

#### For create a new todo
POST: api/json/v1/todos
BODY: {
    title: Todo,
    description: Description for this todo,
    targetDate: 2018-09-27 09:30:00,
    userId: 1
}

#### For update an specific todo
PUT/PATCH: api/json/v1/todos/{todo_id}
BODY: {
    name: New Todo,
    description: New description for this todo,
    targetDate: 2018-09-27 02:50:00,
    userId: 2
}

#### For get one specific todo
GET: api/json/v1/todos/{todo_id}

#### For get one specific todo with its tasks and his user
GET: api/json/v1/todos/{todo_id}?include=tasks,user

#### Delete an specific user
DELETE: api/json/v1/todos/{todo_id}

### TASK EndPoints
#### For get all tasks
GET: api/json/v1/tasks

#### For get all tasks with it todo
GET: api/json/v1/tasks?include=todo

#### For create a new task
POST: api/json/v1/tasks
BODY: {
    title: Task,
    description: Description for this task,
    status: pending,
    todoId: 1
}

#### For update an specific task
PUT/PATCH: api/json/v1/tasks/{task_id}
BODY: {
    title: New Task,
    description: New description for this task,
    status: completed,
    todoId: 2
}

#### For get one specific task
GET: api/json/v1/tasks/{task_id}

#### For get one specific task with it todo
GET: api/json/v1/tasks/{task_id}?include=todo

#### Delete an specific task
DELETE: api/json/v1/tasks/{task_id}

### ASSIGN EndPoints
#### For get all the tasks assigned
GET: api/json/v1/assign

#### For get all the tasks assigned with it task and the assigned user
GET: api/json/v1/assign?include=task,user

#### For assign a task to a user
POST: api/json/v1/assign
BODY: {
    userId: 1
    taskId: 1
}

### COMMENT TODO EndPoints
#### For get all comments in todos
GET: api/json/v1/comments/todos

#### For get all comments with it todo and user
GET: api/json/v1/comments/todos?include=user,todo

#### For create a new comment in todo
POST: api/json/v1/comments/todos
BODY: {
    userId: 1,
    todoId: 1,
    comment: Comment for this todo
}

#### For update a comment in todo
PUT/PATCH: api/json/v1/comments/todos/{todo_comment_id}
BODY: {
    userId: 1,
    todoId: 1,
    comment: New comment for this todo
}

#### For get one specific comment in todo
GET: api/json/v1/comments/todos/{todo_comment_id}

#### For get one specific task with it todo
GET: api/json/v1/comments/todos/{todo_comment_id}?include=user,todo

#### Delete an specific comment
DELETE: api/json/v1/comments/todos/{todo_comment_id}

### COMMENT TASK EndPoints
#### For get all comments in tasks
GET: api/json/v1/comments/tasks

#### For get all comments with it task and user
GET: api/json/v1/comments/tasks?include=user,task

#### For create a new comment in task
POST: api/json/v1/comments/tasks
BODY: {
    userId: 1,
    taskId: 1,
    comment: Comment for this task
}

#### For update a comment in task
PUT/PATCH: api/json/v1/comments/tasks/{task_comment_id}
BODY: {
    userId: 1,
    todoId: 1,
    comment: New comment for this task
}

#### For get one specific comment in todo
GET: api/json/v1/comments/tasks/{task_comment_id}

#### For get one specific task with it task and user
GET: api/json/v1/comments/tasks/{task_comment_id}?include=user,task

#### Delete an specific comment
DELETE: api/json/v1/comments/tasks/{tasks_comment_id}