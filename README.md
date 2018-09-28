# TODO List
This is a small project to understand and practice how to create an Rest API.

The project is created with **Laravel Framework 5.7.5** and **PHP 7.2.4**

### Steps to install the project:
1. Install **Composer**
2. Run **composer install**
3. Create **.env** file
4. Run **php artisan key:generate**
5. Create your database
6. Add configuration to .env file
7. Run **php artisan migrate**
8. Run **php artisan db:seed** (only in Dev environment)
9. Use these endpoints:

### USER EndPoints

#### For get all users
GET: api/json/v1/users

#### For get all users with its todos and/or its tasks
GET: api/json/v1/users?include=todos,tasks

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

#### For get one specific user with his todos
GET: api/json/v1/users/{user_id}?include=todos

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
    name: Todo,
    description: Description for this todo,
    userId: 1
}

#### For update an specific todo
PUT/PATCH: api/json/v1/todos/{todo_id}
BODY: {
    name: New Todo,
    description: New description for this todo,
    userId: 2
}

#### For get one specific todo
GET: api/json/v1/todos/{todo_id}

#### For get one specific todo with its tasks
GET: api/json/v1/todos/{todo_id}?include=tasks

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
    name: Task,
    description: Description for this task,
    todoId: 1
}

#### For update an specific task
PUT/PATCH: api/json/v1/tasks/{task_id}
BODY: {
    name: New Task,
    description: New description for this task,
    todoId: 2
}

#### For get one specific task
GET: api/json/v1/tasks/{task_id}

#### For get one specific task with it todo
GET: api/json/v1/tasks/{task_id}?include=todo

#### Delete an specific task
DELETE: api/json/v1/tasks/{task_id}