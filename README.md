# BDR


## Pré-requisitos
- docker
- docker-compose


## Instalação

`git clone git@github.com:robertoarruda/bdr.git`

Entre no diretório do projeto `cd bdr`

Setar permissão no dir storage `chmod -R 777 api/app/tmp`

Levante o docker do projeto `docker-compose up -d`

Entre no container `docker exec -ti mysql55.docker bash`

Inicie o mysql `mysql -u docker -p` `[senha => docker]`

Execute a query:
```
CREATE DATABASE `bdr`;

USE `bdr`;

DROP TABLE IF EXISTS `tasks`;

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `description` text,
  `priority` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
```

Cadastre um tarefa
```
curl --request POST \
  --url http://localhost/api/tasks \
  --header 'content-type: application/json' \
  --data '{
  "title": "Título",
  "description": "Descrição",
  "priority": "1"
}'
```

Liste as tarefas
```
curl --request GET \
  --url http://localhost/api/tasks
```

Consulte uma tarefa
```
curl --request GET \
  --url http://localhost/api/tasks/[id]
```

Edite uma tarefa
```
curl --request PUT \
  --url http://localhost/api/tasks/[id] \
  --header 'content-type: application/json' \
  --data '{
  "title": "Alterado",
  "description": "Descrição"
}'
```

Exclua uma tarefa
```
curl --request DELETE \
  --url http://localhost/api/tasks/[id] \
  --header 'content-type: application/json'
```