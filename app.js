async function putTodo(todo) {
    const response = await fetch('api/todo', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(todo)
    });

    if (response.ok) {
        return response.json();
    }

}

putTodo({
        title: 'updated todo',
        completed: true
    })
    .then(data => console.log(data));


function postTodo(todo) {
    fetch('api/todo', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(todo)
        })
        .then(response => response.json())
        .then(data => {
            console.log('Success:', data);
        })

}

postTodo({
    title: 'new todo',
    completed: false
});

function deleteTodo(todoId) {
    fetch(`api/todo/${todoId}`, {
            method: 'DELETE'
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to delete todo');
            }
            console.log('Todo deleted successfully');
        })

}

deleteTodo(1);

// example using the FETCH API to do a GET request
function getTodos() {
    fetch('api/todo')

    .then(response => response.json())
        .then(json => drawTodos(json))
        .catch(error => showToastMessage('Failed to retrieve todos...'));
}

getTodos();