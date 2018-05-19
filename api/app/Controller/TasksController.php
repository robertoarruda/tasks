<?php

class TasksController extends AppController
{
    public $autoRender = false;

    public $layout = false;

    public function beforeFilter()
    {
        if (!empty($this->request->data)) {
            return true;
        }

        $this->request->data = (array) $this->request->input('json_decode');
        return true;
    }

    public function index()
    {
        if (!$this->request->isGet()) {
            throw new MethodNotAllowedException();
        }

        $tasks = $this->Task->find('all', array('order' => 'priority'));

        return $this->jsonResponse($tasks);
    }

    public function view($id)
    {
        if (!$this->request->isGet()) {
            throw new MethodNotAllowedException();
        }

        if (empty($id)) {
            throw new BadRequestException();
        }

        $task = $this->Task->findById($id);

        return $this->jsonResponse($task);
    }

    public function add()
    {
        if (!$this->request->isPost()) {
            throw new MethodNotAllowedException();
        }

        $this->Task->id = null;
        if (!$this->Task->save($this->request->data)) {
            throw new InternalErrorException();
        }

        $id = $this->Task->getLastInsertID();
        $task = $this->Task->findById($id);

        return $this->jsonResponse($task, 201);
    }

    public function edit($id)
    {
        if (!$this->request->isPut()) {
            throw new MethodNotAllowedException();
        }

        if (empty($id)) {
            throw new BadRequestException();
        }

        $task = $this->Task->findById($id);
        if (empty($task)) {
            throw new BadRequestException();
        }

        $this->Task->id = $id;
        $this->request->data['id'] = $id;
        if (!$this->Task->save($this->request->data)) {
            throw new InternalErrorException();
        }

        $task = $this->Task->findById($id);

        return $this->jsonResponse($task);
    }

    public function delete($id)
    {
        if (!$this->request->isDelete()) {
            throw new MethodNotAllowedException();
        }

        if (empty($id)) {
            throw new BadRequestException();
        }

        $task = $this->Task->findById($id);
        if (empty($task)) {
            throw new BadRequestException();
        }

        if (!$this->Task->delete($id)) {
            throw new InternalErrorException();
        }

        return $this->jsonResponse(array(
            'message' => 'Deleted',
            'id' => $id,
        ));
    }

    private function jsonResponse($data = array(), $code = 200)
    {
        $this->response->type('application/json');
        $this->response->statusCode($code);

        return json_encode($data);
    }
}
