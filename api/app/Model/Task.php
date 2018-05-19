<?php

class Task extends AppModel
{
    public function beforeSave($options = array())
    {
        $this->data['Task'] = $this->beforeSavePriority($this->data['Task']);

        return parent::beforeSave($options);
    }

    public function afterSave($created, $options = array())
    {
        $this->orderPriorities();

        return parent::afterSave($created, $options);
    }

    public function afterDelete()
    {
        $this->orderPriorities();

        return parent::afterDelete();
    }

    public function beforeSavePriority($data = array())
    {
        if (!empty($data['priority'])) {
            $return = $this->parsePriority($data);
            $this->orderPriorities($data['priority']);

            return $return;
        }

        $data['priority'] = $this->getLastPriority();

        return $data;
    }

    private function parsePriority($data = array())
    {
        if (empty($data['id'])) {
            return $data;
        }

        $task = $this->findById($data['id']);
        if (empty($task)) {
            return $data;
        }

        if ($task['Task']['priority'] < $data['priority']) {
            $data['priority'] += 1;
        }

        return $data;
    }

    private function getLastPriority()
    {
        $task = $this->find('first', array('order' => array('priority' => 'DESC')));

        return (isset($task['Task']['priority'])) ? $task['Task']['priority'] : 0;
    }

    private function orderPriorities($reserve = 0)
    {
        $tasks = $this->find('list', array(
            'fields' => array('id', 'priority'),
            'order' => 'priority',
        ));

        $tasksOrdered = array();

        $correctPriority = 0;
        foreach ((array) $tasks as $taskId => $task) {
            $correctPriority++;

            if ($correctPriority == $reserve) {
                $correctPriority++;
            }

            if ($task == $correctPriority) {
                continue;
            }

            $tasksOrdered[] = array(
                'id' => $taskId,
                'priority' => $correctPriority,
            );
        }

        $tasksOrdered = array_filter($tasksOrdered);
        if (empty($tasksOrdered)) {
            return false;
        }

        $taskModel = new Task();

        return $taskModel->saveMany($tasksOrdered, array('callbacks' => false));
    }
}
