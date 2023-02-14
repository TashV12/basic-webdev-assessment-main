<?php
require_once("todo.class.php");
class TodoController {
  
    private const PATH = __DIR__."/todo.json";
    private array $todos = [];

    public function __construct() {
        $content = file_get_contents(self::PATH);
        if ($content === false) {
            throw new Exception(self::PATH . " does not exist");
        }  
        $dataArray = json_decode($content, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            foreach($dataArray as $data) {
                if (isset($data['id']) && isset($data['title'])) {
                    $this->todos[] = new Todo($data['id'], $data['title'], $data['description'], $data['done']);
                }
            }
        }
    }

    public function loadAll() : array {
        return $this->todos;
    }

    public function load(string $id) : Todo {
        foreach($this->todos as $todo) {
            if ($todo->id == $id) {
                return $todo;
            }
        }
        throw new Exception("Todo with ID '$id' not found");
    }

    public function create(Todo $todo) : bool {
        $content = file_get_contents(self::PATH);
        $dataArray = json_decode($content, true);
        // Append new data to the Json
        $dataArray[] = $todo;
        // Write the updated data to the file
        file_put_contents(self::PATH, json_encode($dataArray));
        return true;
    }

    public function update(string $id, Todo $todo) : bool {
      // Read the contents of the json file
      $content = file_get_contents(self::PATH);
      $dataArray = json_decode($content, true);
      // Find the index of the Todo to update
      $index = -1;
      for ($i = 0; $i < count($dataArray); $i++) {
        if ($dataArray[$i]['id'] === $id) {
          $index = $i;
          break;
        }
      }
      // Check if Todo with the specified ID was found
      if ($index === -1) {
        throw new Exception("Todo with ID '$id' not found");
      }
      // Update the Todo at the specified index
      $dataArray[$index] = $todo;
      // Write the updated data to the file
      file_put_contents(self::PATH, json_encode($dataArray));
      return true;
    }

    public function delete(string $id) : bool {
        $content = file_get_contents(self::PATH);
        $dataArray = json_decode($content, true);
        // Find the index of the Todo to delete
        $index = -1;
        for ($i = 0; $i < count($dataArray); $i++) {
          if ($dataArray[$i]['id'] == $id) {
            $index = $i;
            break;
            }
            }
            if ($index === -1) {
            return false;
            }
            // Remove the Todo from the array
            array_splice($dataArray, $index, 1);
            // Write the updated data to the file
            $result = file_put_contents(self::PATH, json_encode($dataArray));
            return $result !== false;
            }
            
            
            
            
            
